<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\page\UserController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\page\BarangController;
use App\Http\Controllers\page\LaporanController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\page\AngsuranController;
use App\Http\Controllers\page\BerandaController;
use App\Http\Controllers\page\PelangganController;
use App\Http\Controllers\page\JenisBarangController;
use App\Http\Controllers\page\PenggunaController;
use App\Http\Controllers\page\PenjualanKreditController;

Route::middleware('guest')->group(function () {
    #Route Login
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');

    #Route Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    #Route Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    #Route Home
    Route::get('/home', [BerandaController::class, 'index'])->name('home');

    #Route Profile
    Route::get('/ganti-password/{id}', [UserController::class, 'showResetPassword'])->name('gantiPassword');
    Route::put('/ganti-password/{id}', [UserController::class, 'resetPassword'])->name('gantiPassword.update');
});

Route::middleware(['auth', 'checkRole:superadmin'])->group(function () {
    #Route Manajemen User
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/tambah-pengguna', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/tambah-pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{id}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::put('/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');
});

Route::middleware(['auth', 'checkRole:manajer,karyawan'])->group(function () {
    #Route Laporan
    Route::get('/laporan/angsuran/per-pelanggan', [LaporanController::class, 'indexAngsuranPelanggan'])->name('laporan.angsuranPelanggan');
    Route::get('/laporan/angsuran/per-periode', [LaporanController::class, 'indexAngsuranPeriode'])->name('laporan.angsuranPeriode');
    Route::get('/laporan/angsuran/per-pelanggan/cetak', [LaporanController::class, 'cetakAngsuranPelanggan'])->name('laporan.cetakAngsuranPelanggan');
    Route::get('/laporan/angsuran/per-periode/cetak', [LaporanController::class, 'cetakAngsuranPeriode'])->name('laporan.cetakAngsuranPeriode');
    Route::get('/laporan/penjualan/per-pelanggan', [LaporanController::class, 'indexPenjualanPelanggan'])->name('laporan.penjualanPelanggan');
    Route::get('/laporan/penjualan/per-periode', [LaporanController::class, 'indexPenjualanPeriode'])->name('laporan.penjualanPeriode');
    Route::get('/laporan/penjualan/terlaris', [LaporanController::class, 'indexPenjualanTerlaris'])->name('laporan.penjualanTerlaris');
    Route::get('/laporan/penjualan/per-pelanggan/cetak', [LaporanController::class, 'cetakPenjualanPelanggan'])->name('laporan.cetakPenjualanPelanggan');
    Route::get('/laporan/penjualan/per-periode/cetak', [LaporanController::class, 'cetakPenjualanPeriode'])->name('laporan.cetakPenjualanPeriode');
    Route::get('/laporan/penjualan/terlaris/cetak', [LaporanController::class, 'cetakPenjualanTerlaris'])->name('laporan.cetakPenjualanTerlaris');
    Route::get('/laporan/piutang', [LaporanController::class, 'indexPiutang'])->name('laporan.piutang');
    Route::get('/laporan/piutang/cetak', [LaporanController::class, 'cetakLaporanPiutang'])->name('laporan.cetakLaporanPiutang');
});

Route::middleware(['auth', 'checkRole:manajer,karyawan'])->group(function () {
    #Route Kartu Piutang
    Route::get('/kartu-piutang', [LaporanController::class, 'indexKartuPiutang'])->name('kartuPiutang');
    Route::get('/kartu-piutang/cetak', [LaporanController::class, 'cetakKartuPiutang'])->name('kartuPiutang.cetak');
});

Route::middleware(['auth', 'checkRole:karyawan'])->group(function () {
    # Route Barang
    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::get('/tambah-barang', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/tambah-barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    #Route Jenis Barang
    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang');
    Route::get('/tambah-jenis-barang', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
    Route::post('/tambah-jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
    Route::get('/jenis-barang/{id}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
    Route::put('/jenis-barang/{id}/edit', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::delete('/jenis-barang/{id}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');

    # Route Pelanggan
    Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan');
    Route::get('/tambah-pelanggan', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/tambah-pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/{id}/edit', [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::put('/pelanggan/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::delete('/pelanggan/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');
    Route::get('pelanggan/{id}/download', [PelangganController::class, 'downloadIdentitas'])->name('pelanggan.download');

    #Route Penjualan
    Route::get('/penjualan', [PenjualanKreditController::class, 'index'])->name('penjualan');
    Route::get('/tambah-penjualan', [PenjualanKreditController::class, 'create'])->name('penjualan.create');
    Route::post('/tambah-penjualan', [PenjualanKreditController::class, 'store'])->name('penjualan.store');
    Route::get('/penjualan/{id}/edit', [PenjualanKreditController::class, 'edit'])->name('penjualan.edit');
    Route::put('/penjualan/{id}', [PenjualanKreditController::class, 'update'])->name('penjualan.update');
    Route::delete('/penjualan/{id}', [PenjualanKreditController::class, 'destroy'])->name('penjualan.destroy');
    Route::get('/penjualan/{id}', [PenjualanKreditController::class, 'show'])->name('penjualan.show');
    Route::get('/penjualan/{id}/faktur', [PenjualanKreditController::class, 'generatePDF'])->name('penjualan.faktur');

    #Route Angsuran
    Route::get('/angsuran', [AngsuranController::class, 'index'])->name('angsuran');
    Route::get('/tambah-angsuran', [AngsuranController::class, 'create'])->name('angsuran.create');
    Route::post('/tambah-angsuran', [AngsuranController::class, 'store'])->name('angsuran.store');
    Route::get('/angsuran/{id}/edit', [AngsuranController::class, 'edit'])->name('angsuran.edit');
    Route::put('/angsuran/{id}', [AngsuranController::class, 'update'])->name('angsuran.update');
    Route::delete('/angsuran/{id}', [AngsuranController::class, 'destroy'])->name('angsuran.destroy');
    Route::get('/angsuran/remaining/{id}', [AngsuranController::class, 'getRemainingAngsuran']);
    Route::get('/agsuran/cetak', [AngsuranController::class, 'cetakDataAngsuran'])->name('angsuran.cetakDataAngsuran');
    Route::get('/angsuran/last-payment-date/{penjualanKreditId}', [AngsuranController::class, 'getLastPaymentDate']);
});

Auth::routes();
