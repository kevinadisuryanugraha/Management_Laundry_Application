<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Member;
use App\Models\Layanan;
use App\Models\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Total transaksi
        $totalTransaksi = Transaksi::count();

        // Total pendapatan
        $totalPendapatan = Transaksi::sum('total_harga');

        // Total member
        $totalMember = Member::count();

        // Layanan populer
        $layananPopuler = Layanan::withCount(['transaksis as total' => function ($query) {
            $query->whereNull('transaksi_details.deleted_at'); // pastikan hanya transaksi aktif
        }])
            ->orderByDesc('total')
            ->first();

        $layananPopulerName = $layananPopuler ? $layananPopuler->nama_layanan : '-';

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['member', 'layanan'])
            ->latest()
            ->take(5)
            ->get();

        // Chart pendapatan harian (1 bulan terakhir)
        $chartPendapatan = Transaksi::where('tanggal_masuk', '>=', now()->subDays(30))
            ->selectRaw('DATE(tanggal_masuk) as tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->pluck('total', 'tanggal');

        // Chart pendapatan bulanan (tahun ini)
        $chartPendapatanBulan = Transaksi::whereYear('tanggal_masuk', now()->year)
            ->selectRaw('MONTH(tanggal_masuk) as bulan, SUM(total_harga) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        return view('admin.dashboard', compact(
            'totalTransaksi',
            'totalPendapatan',
            'totalMember',
            'layananPopulerName',
            'transaksiTerbaru',
            'chartPendapatan',
            'chartPendapatanBulan'
        ));
    }
}
