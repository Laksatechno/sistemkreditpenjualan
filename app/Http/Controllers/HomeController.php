<?php

namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\Angsuran;
use App\Models\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\PenjualanKredit;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalBarang = Barang::count();
        $totalPelanggan = Pelanggan::count();
        $totalPenjualan = PenjualanKredit::sum('total_harga');
        $totalAngsuran = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur')
            ->whereNotNull('no_angsur')
            ->count();

        return view('home', compact('totalBarang', 'totalPelanggan', 'totalPenjualan', 'totalAngsuran'));
    
    }
}
