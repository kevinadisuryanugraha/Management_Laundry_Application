<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->format('m');
        $tahun = $request->tahun ?? Carbon::now()->format('Y');

        $transaksi = Transaksi::with('member')
            ->whereYear('tanggal_masuk', $tahun)
            ->whereMonth('tanggal_masuk', $bulan)
            ->where('dibayar', 'sudah')
            ->get();

        $total = $transaksi->sum('total_harga');

        // Group data per tanggal
        $chartData = $transaksi->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->tanggal_masuk)->format('d');
        })->map(function ($item) {
            return $item->sum('total_harga');
        });

        return view('admin.laporan_keuangan.index', compact('transaksi', 'total', 'bulan', 'tahun', 'chartData'));
    }

    public function cetak(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->format('m');
        $tahun = $request->tahun ?? Carbon::now()->format('Y');

        $transaksi = Transaksi::whereYear('tanggal_masuk', $tahun)
            ->whereMonth('tanggal_masuk', $bulan)
            ->where('dibayar', 'sudah')
            ->get();

        $total = $transaksi->sum('total_harga');

        $pdf = Pdf::loadView('admin.laporan_keuangan_pdf', compact('transaksi', 'total', 'bulan', 'tahun'));

        return $pdf->download("laporan-keuangan-{$bulan}-{$tahun}.pdf");
    }
}
