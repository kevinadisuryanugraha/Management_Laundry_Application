<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Layanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\FonnteService;
use Milon\Barcode\DNS1D;


class TransaksiController extends Controller
{
    // Index Transaksi
    public function index()
    {
        $transaksis = Transaksi::with(['member', 'layanan'])->latest()->get();
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function markAsPaid($id)
    {
        $transaksi = Transaksi::with('member', 'layanan')->findOrFail($id);
        $transaksi->dibayar = 'sudah';
        $transaksi->save();

        $member = $transaksi->member;

        if ($member && $member->no_hp) {
            // Normalisasi nomor HP untuk Fonnte (tanpa +, format 08123456789 atau 628123456789)
            $no_hp = preg_replace('/[^0-9]/', '', $member->no_hp);
            if (substr($no_hp, 0, 2) == '62') {
                // nomor sudah format 62..., biarkan
            } elseif (substr($no_hp, 0, 1) == '0') {
                $no_hp = '62' . substr($no_hp, 1);
            }

            // Pesan WhatsApp
            $pesan = "*Invoice Pembayaran Laundry* 🧺\n\n" .
                "Halo *{$member->nama_member}*,\n\n" .
                "Terima kasih sudah melakukan pembayaran ✅\n" .
                "No Transaksi : *{$transaksi->nomor_transaksi}*\n" .
                "Total : *Rp " . number_format($transaksi->total_harga, 0, ',', '.') . "*\n\n" .
                "_Salam hangat dari Laundry XYZ_ 💙";

            $token = config('fonnte.token');

            // Kirim pesan teks saja
            $resultText = FonnteService::send($no_hp, $pesan, $token);

            // Debug sementara untuk memastikan pesan berhasil dikirim
            // dd([
            //     'text_response' => $resultText,
            //     'no_hp' => $no_hp,
            // ]);
        }

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi sudah ditandai lunas, pesan terkirim ke WhatsApp.');
    }

    public function printInvoice($id)
    {
        $transaksi = Transaksi::with('member', 'layanan')->findOrFail($id);
        return view('admin.transaksi.invoice', compact('transaksi'));
    }

    // Halaman Invoice
    public function invoice($id)
    {
        $transaksi = Transaksi::with(['member', 'layanan'])->findOrFail($id);
        return view('admin.transaksi.invoice', compact('transaksi'));
    }

    // Bayar Transaksi
    public function bayar(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->update(['dibayar' => 'sudah']);

        return redirect()->route('transaksi.index')->with('success', 'Pembayaran berhasil.');
    }

    // Form Tambah
    public function create()
    {
        $lastId = DB::table('transaksis')->max('id') ?? 0;
        $newId = $lastId + 1;

        $pref = 'TRX';
        $date = now()->format('Ymd'); // format lebih rapi
        $counter = str_pad($newId, 5, '0', STR_PAD_LEFT);
        $code = "{$pref}-{$date}-{$counter}";

        $members = Member::all();
        $layanans = Layanan::all();

        return view('admin.transaksi.create', compact('code', 'members', 'layanans'));
    }

    // Simpan Transaksi
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'layanan_id' => 'required|array',
            'layanan_id.*' => 'exists:layanans,id',
            'qty' => 'required|array',
            'qty.*' => 'numeric|min:0.1',
            'tanggal_masuk' => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'berat' => 'required|numeric|min:0.1',
            'status' => 'required|in:pending,proses,selesai,diambil',
            'catatan' => 'nullable|string'
        ]);

        $transaksi = DB::transaction(function () use ($request) {

            // Generate nomor transaksi
            $lastId = DB::table('transaksis')->max('id') ?? 0;
            $newId = $lastId + 1;
            $pref = 'TRX';
            $date = now()->format('Ymd');
            $counter = str_pad($newId, 5, '0', STR_PAD_LEFT);
            $code = "{$pref}-{$date}-{$counter}";

            // Simpan transaksi
            $transaksi = Transaksi::create([
                'nomor_transaksi' => $code,
                'member_id' => $request->member_id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'estimasi_selesai' => $request->estimasi_selesai,
                'berat' => $request->berat,
                'status' => $request->status,
                'total_harga' => 0,
                'dibayar' => 'belum', // otomatis
                'catatan' => $request->catatan,
            ]);

            $total = 0;

            // Simpan detail transaksi
            foreach ($request->layanan_id as $index => $layananId) {
                $layanan = Layanan::findOrFail($layananId);
                $qty = $request->qty[$index];
                $subtotal = $qty * $layanan->harga;

                DB::table('transaksi_details')->insert([
                    'transaksi_id' => $transaksi->id,
                    'layanan_id' => $layananId,
                    'qty' => $qty,
                    'harga' => $layanan->harga,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $total += $subtotal;
            }

            // update total harga
            $transaksi->update(['total_harga' => $total]);

            return $transaksi;
        });

        // Redirect ke halaman invoice
        return redirect()->route('transaksi.invoice', $transaksi->id)
            ->with('success', 'Transaksi berhasil dibuat. Silakan lakukan pembayaran.');
    }

    // Detail Transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with(['member', 'transaksiDetails.layanan'])->findOrFail($id);

        return view('admin.transaksi.detail', compact('transaksi'));
    }

    // Form Edit
    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $members = Member::all();
        $layanans = Layanan::all();

        return view('admin.transaksi.edit', compact('transaksi', 'members', 'layanans'));
    }

    // Update Transaksi
    public function update(Request $request, $id)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'layanan_id' => 'required|array',
            'layanan_id.*' => 'exists:layanans,id',
            'qty' => 'required|array',
            'qty.*' => 'numeric|min:0.1',
            'tanggal_masuk' => 'required|date',
            'estimasi_selesai' => 'nullable|date',
            'berat' => 'required|numeric|min:0.1',
            'status' => 'required|in:pending,proses,selesai,diambil',
            'dibayar' => 'nullable',
            'catatan' => 'nullable|string'
        ]);

        DB::transaction(function () use ($request, $id) {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->update([
                'member_id' => $request->member_id,
                'tanggal_masuk' => $request->tanggal_masuk,
                'estimasi_selesai' => $request->estimasi_selesai,
                'berat' => $request->berat,
                'status' => $request->status,
                'dibayar' => $request->dibayar,
                'catatan' => $request->catatan,
                'total_harga' => 0, // sementara
            ]);

            // Hapus detail lama
            DB::table('transaksi_details')->where('transaksi_id', $transaksi->id)->delete();

            $total = 0;

            foreach ($request->layanan_id as $index => $layananId) {
                $layanan = Layanan::findOrFail($layananId);
                $qty = $request->qty[$index];
                $subtotal = $qty * $layanan->harga;

                DB::table('transaksi_details')->insert([
                    'transaksi_id' => $transaksi->id,
                    'layanan_id' => $layananId,
                    'qty' => $qty,
                    'harga' => $layanan->harga,
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                $total += $subtotal;
            }

            // Update total harga
            $transaksi->update(['total_harga' => $total]);
        });

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate');
    }

    // Soft Delete
    public function softdelete($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }

    // Restore List
    public function restore()
    {
        $transaksis = Transaksi::onlyTrashed()->get();
        return view('admin.transaksi.restore', compact('transaksis'));
    }

    // Restore Data
    public function restoreData($id)
    {
        $transaksi = Transaksi::onlyTrashed()->findOrFail($id);
        $transaksi->restore();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil direstore');
    }

    public function laporan(Request $request)
    {
        $query = Transaksi::with('member', 'layanan');

        // Filter berdasarkan tanggal jika dipilih
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_masuk', [$request->start_date, $request->end_date]);
        }

        $transaksi = $query->orderBy('tanggal_masuk', 'desc')->get();

        return view('admin.laporan', compact('transaksi'));
    }

    public function cetak(Request $request)
    {
        $query = Transaksi::with('member', 'layanan');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('tanggal_masuk', [$request->start_date, $request->end_date]);
        }

        $transaksi = $query->orderBy('tanggal_masuk', 'desc')->get();

        $pdf = PDF::loadView('admin.laporan_pdf', compact('transaksi'));
        return $pdf->download('laporan-transaksi.pdf');
    }
}
