<?php

namespace App\Http\Controllers\page;

use App\Models\User;
use App\Models\Barang;
use App\Models\Angsuran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\PenjualanKredit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalPelanggan = Pelanggan::count();
        $totalPenjualan = PenjualanKredit::sum('total_harga');
        $totalAngsuran = Angsuran::count();
        $totalAngsuranDiterima = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur')
            ->whereNotNull('no_angsur')
            ->count();
        $totalNominalAngsuran = Angsuran::sum('jumlah_angsur');
        $totalKredit = PenjualanKredit::sum(DB::raw('total_angsur_bulanan * jangka_pembayaran'));
        $totalAngsuranTerutang = Angsuran::whereNull('tanggal_pembayaran')
            ->whereNull('jumlah_angsur')
            ->whereNull('no_angsur')
            ->count();
        $totalNominalAngsuranTerutang = $totalKredit - $totalNominalAngsuran;
        $totalUser = User::count();

        return view('beranda.index', compact('totalBarang', 'totalPelanggan', 'totalPenjualan', 'totalAngsuranDiterima', 'totalNominalAngsuran', 'totalKredit', 'totalAngsuranTerutang', 'totalAngsuran', 'totalNominalAngsuranTerutang', 'totalUser'));
    }
}
