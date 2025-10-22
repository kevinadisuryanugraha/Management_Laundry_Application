<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanKeuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🔹 Auth
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'loginAction'])->name('login.action');

Route::middleware('auth')->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    /**
     * ========================
     * ADMIN / SUPER ADMIN
     * ========================
     */
    Route::middleware('role:Admin')->group(function () {
        // Layanan
        Route::get('layanan/index', [LayananController::class, 'index'])->name('layanan.index');
        Route::get('layanan/create', [LayananController::class, 'create'])->name('layanan.create');
        Route::post('layanan/store', [LayananController::class, 'store'])->name('layanan.store');
        Route::get('layanan/edit/{id}', [LayananController::class, 'edit'])->name('layanan.edit');
        Route::put('layanan/update/{id}', [LayananController::class, 'update'])->name('layanan.update');
        Route::delete('layanan/destroy/{id}', [LayananController::class, 'softDelete'])->name('layanan.softdelete');
        Route::get('layanan/restore', [LayananController::class, 'indexRestore'])->name('layanan.restore.index');
        Route::get('layanan/restore/{id}', [LayananController::class, 'restore'])->name('layanan.restore');
        Route::delete('layanan/restore/destroy/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

        // Kelola User
        Route::resource('user', UserController::class);
    });

    /**
     * ========================
     * KASIR
     * ========================
     */
    Route::middleware('role:Kasir')->group(function () {
        Route::resource('transaksi', TransaksiController::class);
        Route::delete('transaksi/softdelete/{id}', [TransaksiController::class, 'softdelete'])->name('transaksi.softdelete');
        Route::get('transaksi/restore', [TransaksiController::class, 'restore'])->name('transaksi.restore');
        Route::post('transaksi/restore/{id}', [TransaksiController::class, 'restoreData'])->name('transaksi.restoreData');
        Route::get('transaksi/{id}/invoice', [TransaksiController::class, 'invoice'])->name('transaksi.invoice');
        Route::get('transaksi/{id}/print', [TransaksiController::class, 'printInvoice'])->name('transaksi.print');
        Route::post('transaksi/{id}/bayar', [TransaksiController::class, 'markAsPaid'])->name('transaksi.bayar');
        Route::put('transaksi/{id}/update-status', [TransaksiController::class, 'update'])->name('transaksi.updateStatus');
    });

    /**
     * ========================
     * MEMBER (Admin & Kasir)
     * ========================
     */
    Route::middleware(['role:Admin,Kasir'])->group(function () {
        Route::get('member/index', [MemberController::class, 'index'])->name('member.index');
        Route::get('member/create', [MemberController::class, 'create'])->name('member.create');
        Route::post('member/store', [MemberController::class, 'store'])->name('member.store');
        Route::get('member/edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
        Route::put('member/update/{id}', [MemberController::class, 'update'])->name('member.update');
        Route::delete('member/destroy/{id}', [MemberController::class, 'softDelete'])->name('member.softdelete');

        // Restore
        Route::get('member/restore', [MemberController::class, 'indexRestore'])->name('member.restore.index');
        Route::post('member/restore/{id}', [MemberController::class, 'restore'])->name('member.restore');
        Route::delete('member/restore/destroy/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
    });


    /**
     * ========================
     * MANAJEMEN
     * ========================
     */
    Route::middleware('role:Manajemen')->group(function () {
        // Laporan Transaksi
        Route::get('laporan/transaksi', [TransaksiController::class, 'laporan'])->name('laporan.transaksi');
        Route::get('laporan/transaksi/cetak', [TransaksiController::class, 'cetak'])->name('laporan.transaksi.cetak');

        // Laporan Member
        Route::get('laporan/member', [MemberController::class, 'laporan'])->name('laporan.member');
        Route::get('laporan/member/cetak', [MemberController::class, 'cetak'])->name('laporan.member.cetak');

        // Laporan Keuangan
        Route::get('laporan/keuangan', [LaporanKeuanganController::class, 'index'])->name('laporan.keuangan');
        Route::get('laporan/keuangan/cetak', [LaporanKeuanganController::class, 'cetak'])->name('laporan.keuangan.cetak');
    });
});
