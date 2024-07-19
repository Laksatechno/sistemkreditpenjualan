<?php

namespace App\Http\Controllers\page;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Barang;
use App\Models\Angsuran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\PenjualanKredit;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DetailPenjualanKredit;

class LaporanController extends Controller
{
    public function indexAngsuranPelanggan(Request $request)
    {
        Carbon::setLocale('id');
        $angsuran = collect();

        $pelangganList = Pelanggan::whereHas('penjualanKredit')
            ->orderBy('nama_pelanggan')
            ->get();

        if ($request->has('pelanggan')) {
            $request->validate([
                'pelanggan' => 'required'
            ], [
                'pelanggan.required' => 'Kolom pencarian harus diisi.'
            ]);

            $searchTerm = $request->input('pelanggan');
            $angsuran = Angsuran::whereNotNull('tanggal_pembayaran')
                ->whereNotNull('jumlah_angsur')
                ->whereHas('penjualanKredit.pelanggan', function ($query) use ($searchTerm) {
                    $query->where('id_pelanggan', $searchTerm);
                })
                ->join('penjualan_kredit', 'angsuran.penjualan_kredit_id', '=', 'penjualan_kredit.id_penjualan_kredit')
                ->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
                ->select('angsuran.*')
                ->orderBy('tanggal_pembayaran', 'asc')
                ->get();
        }

        return view('laporan.angsuran-pelanggan', compact('angsuran', 'pelangganList'));
    }

    public function indexAngsuranPeriode(Request $request)
    {
        Carbon::setLocale('id');
        $angsuran = collect();
        $startDate = null;
        $endDate = null;

        if ($request->has('start') && $request->has('end')) {
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
            ], [
                'start.required' => 'Tanggal awal harus diisi',
                'start.date' => 'Format tanggal awal tidak valid',
                'end.required' => 'Tanggal akhir harus diisi',
                'end.date' => 'Format tanggal akhir tidak valid',
                'end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal',
            ]);

            $startDate = Carbon::parse($request->input('start'))->startOfDay();
            $endDate = Carbon::parse($request->input('end'))->endOfDay();

            $angsuran = Angsuran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
                ->with('penjualanKredit.pelanggan')
                ->orderBy('tanggal_pembayaran', 'asc')
                ->get();
        }

        return view('laporan.angsuran-periode', compact('angsuran', 'startDate', 'endDate'));
    }

    public function indexPenjualanPelanggan(Request $request)
    {
        Carbon::setLocale('id');
        $listPelanggan = Pelanggan::has('penjualanKredit')->orderBy('nama_pelanggan')->get();
        $penjualanKredit = collect();

        if ($request->has('pelanggan')) {
            $request->validate([
                'pelanggan' => 'required'
            ], [
                'pelanggan.required' => 'Kolom pencarian harus diisi.'
            ]);

            $pelangganId = $request->input('pelanggan');
            $penjualanKredit = PenjualanKredit::where('pelanggan_id', $pelangganId)
                ->with(['pelanggan', 'detailPenjualanKredit.barang'])
                ->orderBy('tanggal_penjualan', 'desc')
                ->get();
        }

        return view('laporan.penjualan-pelanggan', compact('penjualanKredit', 'listPelanggan'));
    }

    public function indexPenjualanPeriode(Request $request)
    {
        Carbon::setLocale('id');
        $penjualanKredit = collect();
        $startDate = null;
        $endDate = null;

        if ($request->has('start') && $request->has('end')) {
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
            ], [
                'start.required' => 'Tanggal awal harus diisi',
                'start.date' => 'Format tanggal awal tidak valid',
                'end.required' => 'Tanggal akhir harus diisi',
                'end.date' => 'Format tanggal akhir tidak valid',
                'end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal',
            ]);

            $startDate = Carbon::parse($request->input('start'))->startOfDay();
            $endDate = Carbon::parse($request->input('end'))->endOfDay();

            $penjualanKredit = PenjualanKredit::whereBetween('tanggal_penjualan', [$startDate, $endDate])
                ->with('pelanggan', 'detailPenjualanKredit.barang')
                ->orderBy('tanggal_penjualan', 'desc')
                ->get();
        }

        return view('laporan.penjualan-periode', compact('penjualanKredit', 'startDate', 'endDate'));
    }

    public function indexPenjualanTerlaris(Request $request)
    {
        Carbon::setLocale('id');
        $startDate = null;
        $endDate = null;
        $barangTerlaris = collect([]);

        if ($request->has('start') && $request->has('end')) {
            $request->validate([
                'start' => 'required|date',
                'end' => 'required|date|after_or_equal:start',
            ], [
                'start.required' => 'Tanggal awal harus diisi',
                'start.date' => 'Format tanggal awal tidak valid',
                'end.required' => 'Tanggal akhir harus diisi',
                'end.date' => 'Format tanggal akhir tidak valid',
                'end.after_or_equal' => 'Tanggal akhir harus setelah atau sama dengan tanggal awal',
            ]);

            $startDate = Carbon::parse($request->input('start'))->startOfDay();
            $endDate = Carbon::parse($request->input('end'))->endOfDay();

            $barangTerlaris = DetailPenjualanKredit::select(
                'barang.id_barang',
                'barang.nama_barang',
                'barang.merk',
                'jenis_barang.nama_jenis',
                DB::raw('SUM(detail_penjualan_kredit.kuantitas) as total_terjual')
            )
                ->join('barang', 'detail_penjualan_kredit.barang_id', '=', 'barang.id_barang')
                ->join('jenis_barang', 'barang.jenis_id', '=', 'jenis_barang.id_jenis')
                ->whereHas('penjualanKredit', function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
                })
                ->groupBy('barang.id_barang', 'barang.nama_barang', 'barang.merk', 'jenis_barang.nama_jenis')
                ->orderByDesc('total_terjual')
                ->get();
        }

        return view('laporan.penjualan-terlaris', compact('barangTerlaris', 'startDate', 'endDate'));
    }

    public function indexKartuPiutang(Request $request)
    {
        Carbon::setLocale('id');
        $penjualanKredit = null;
        $angsuran = collect();
        $sisaAngsuran = 0;

        $penjualanIds = PenjualanKredit::with('pelanggan')
            ->get()
            ->map(function ($penjualan) {
                return [
                    'id' => $penjualan->id_penjualan_kredit,
                    'nama' => $penjualan->pelanggan->nama_pelanggan
                ];
            });

        if ($request->has('penjualan')) {
            $request->validate([
                'penjualan' => 'required'
            ], [
                'penjualan.required' => 'ID Penjualan harus dipilih.'
            ]);

            $penjualanId = $request->input('penjualan');
            $penjualanKredit = PenjualanKredit::with(['pelanggan', 'detailPenjualanKredit.barang'])
                ->where('id_penjualan_kredit', $penjualanId)
                ->first();

            if ($penjualanKredit) {
                $angsuran = Angsuran::where('penjualan_kredit_id', $penjualanId)
                    ->get()
                    ->map(function ($angsur, $index) use ($penjualanKredit) {
                        $tanggalPenjualan = Carbon::parse($penjualanKredit->tanggal_penjualan);
                        $jatuhTempo = $tanggalPenjualan->copy()->addMonths($index + 1);
                        $angsur->jatuh_tempo = $jatuhTempo;
                        $angsur->status_pembayaran = $angsur->tanggal_pembayaran && $angsur->jumlah_angsur && $angsur->no_angsur ? 'terbayar' : 'terutang';
                        return $angsur;
                    });

                $angsuran = $angsuran->sortBy(function ($item) {
                    return [
                        $item->status_pembayaran == 'terbayar' ? 0 : 1,
                        $item->tanggal_pembayaran ? Carbon::parse($item->tanggal_pembayaran) : Carbon::now()->addYear(),
                        $item->jumlah_angsur,
                        $item->no_angsur
                    ];
                })->values();

                $totalAngsuran = $penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran;
                $jumlahTerbayar = $angsuran->where('status_pembayaran', 'terbayar')->sum('jumlah_angsur');
                $sisaAngsuran = $totalAngsuran - $jumlahTerbayar;
            }
        }

        return view('laporan.kartu-piutang', compact('penjualanIds', 'penjualanKredit', 'angsuran', 'sisaAngsuran'));
    }

    public function indexPiutang(Request $request)
    {
        Carbon::setLocale('id');

        // Query untuk mendapatkan piutang yang sudah dibayar
        $query = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur');

        if ($search = $request->input('search')) {
            $keyword = '%' . $search . '%';
            $query->whereHas('penjualanKredit.pelanggan', function ($q) use ($keyword) {
                $q->where('nama_pelanggan', 'like', $keyword);
            });
        }

        if ($filter = $request->input('filter-piutang')) {
            switch ($filter) {
                case 'az':
                    $query->orderBy('pelanggan.nama_pelanggan', 'asc');
                    break;
                case 'za':
                    $query->orderBy('pelanggan.nama_pelanggan', 'desc');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'selesai':
                    $query->where('status', 'selesai');
                    break;
                case 'berjalan':
                    $query->where('status', 'berjalan');
                    break;
            }
        }

        $piutang = $query->join('penjualan_kredit', 'angsuran.penjualan_kredit_id', '=', 'penjualan_kredit.id_penjualan_kredit')
            ->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
            ->select('angsuran.*')
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        // Hitung total kredit unik berdasarkan ID penjualan kredit
        $totalKredit = PenjualanKredit::with('angsuran')
            ->get()
            ->sum(function ($penjualanKredit) {
                return $penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran;
            });

        // Hitung total angsuran yang dibayarkan
        $totalAngsuran = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur')
            ->sum('jumlah_angsur');

        // Hitung total angsuran yang terutang
        $totalAngsuranTerutang = $totalKredit - $totalAngsuran;

        return view('laporan.piutang', compact('piutang', 'totalKredit', 'totalAngsuran', 'totalAngsuranTerutang'));
    }









    public function cetakAngsuranPelanggan(Request $request)
    {
        Carbon::setLocale('id');
        $pelangganId = $request->query('pelanggan');

        // Ambil data angsuran berdasarkan ID pelanggan yang dipilih
        $angsuran = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur')
            ->whereHas('penjualanKredit', function ($query) use ($pelangganId) {
                $query->where('pelanggan_id', $pelangganId);
            })
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        if ($angsuran->isEmpty()) {
            return redirect()->route('laporan.angsuranPelanggan')->withErrors(['pelanggan' => 'Data angsuran tidak ditemukan untuk pelanggan ini.']);
        }

        $html = view('laporan.angsuran-pelanggan-pdf', compact('angsuran'))->render();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);

        return $mpdf->Output('laporan_angsuran_pelanggan_' . $angsuran->first()->penjualanKredit->pelanggan->nama_pelanggan . '.pdf', 'D');
    }

    public function cetakAngsuranPeriode(Request $request)
    {
        Carbon::setLocale('id');
        $startDate = Carbon::parse($request->input('start'))->startOfDay();
        $endDate = Carbon::parse($request->input('end'))->endOfDay();

        $angsuran = Angsuran::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->with('penjualanKredit.pelanggan')
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        $html = view('laporan.angsuran-periode-pdf', compact('angsuran', 'startDate', 'endDate'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('laporan_angsuran_periode_' . \Carbon\Carbon::parse($startDate)->translatedFormat('d-F-Y') . '_' . \Carbon\Carbon::parse($endDate)->translatedFormat('d-F-Y') . '.pdf', 'D');
        // return view('laporan.angsuran-periode-pdf', compact('angsuran', 'startDate', 'endDate'));
    }

    public function cetakPenjualanPelanggan(Request $request)
    {
        Carbon::setLocale('id');
        $pelangganId = $request->query('pelanggan');

        $penjualanKredit = PenjualanKredit::where('pelanggan_id', $pelangganId)
            ->with(['pelanggan', 'detailPenjualanKredit.barang'])
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        if ($penjualanKredit->isEmpty()) {
            return redirect()->route('laporan.penjualanPelanggan')->withErrors(['pelanggan' => 'Data penjualan untuk pelanggan tidak ditemukan']);
        }

        $html = view('laporan.penjualan-pelanggan-pdf', compact('penjualanKredit'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('laporan-penjualan-pelanggan-' . $penjualanKredit->first()->pelanggan->nama_pelanggan . '.pdf', 'D');
    }

    public function cetakPenjualanPeriode(Request $request)
    {
        Carbon::setLocale('id');
        $startDate = Carbon::parse($request->input('start'))->startOfDay();
        $endDate = Carbon::parse($request->input('end'))->endOfDay();

        $penjualanKredit = PenjualanKredit::whereBetween('tanggal_penjualan', [$startDate, $endDate])
            ->with('pelanggan', 'detailPenjualanKredit.barang')
            ->orderBy('tanggal_penjualan', 'desc')
            ->get();

        $html = view('laporan.penjualan-periode-pdf', compact('penjualanKredit', 'startDate', 'endDate'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('laporan-penjualan-periode_' . \Carbon\Carbon::parse($startDate)->translatedFormat('d-F-Y') . '_' . \Carbon\Carbon::parse($endDate)->translatedFormat('d-F-Y') . '.pdf', 'D');
        // return view('laporan.penjualan-periode-pdf', compact('penjualanKredit', 'startDate', 'endDate'));
    }

    public function cetakKartuPiutang(Request $request)
    {
        Carbon::setLocale('id');
        $penjualanKredit = null;
        $angsuran = collect();
        $jatuhTempo = null;
        $statusPembayaran = [];
        $sisaAngsuran = 0;

        $penjualanIds = PenjualanKredit::with('pelanggan')->get();

        if ($request->has('penjualan')) {
            $request->validate([
                'penjualan' => 'required'
            ], [
                'penjualan.required' => 'ID Penjualan harus dipilih.'
            ]);

            $penjualanId = $request->input('penjualan');
            $penjualanKredit = PenjualanKredit::with(['pelanggan', 'detailPenjualanKredit.barang'])
                ->where('id_penjualan_kredit', $penjualanId)
                ->first();

            if ($penjualanKredit) {
                $angsuran = Angsuran::where('penjualan_kredit_id', $penjualanId)
                    ->get()
                    ->map(function ($angsur, $index) use ($penjualanKredit) {
                        $tanggalPenjualan = Carbon::parse($penjualanKredit->tanggal_penjualan);
                        $jatuhTempo = $tanggalPenjualan->copy()->addMonths($index + 1);
                        if ($jatuhTempo->lessThan($tanggalPenjualan->addMonths($index))) {
                            $jatuhTempo->addMonth();
                        }
                        $angsur->jatuh_tempo = $jatuhTempo;
                        $angsur->status_pembayaran = $angsur->tanggal_pembayaran && $angsur->jumlah_angsur && $angsur->no_angsur ? 'terbayar' : 'terutang';
                        return $angsur;
                    });

                $angsuran = $angsuran->sortBy(function ($item) {
                    return [
                        $item->status_pembayaran == 'terbayar' ? 0 : 1,
                        $item->tanggal_pembayaran ? Carbon::parse($item->tanggal_pembayaran) : Carbon::now()->addYear(),
                        $item->jumlah_angsur,
                        $item->no_angsur
                    ];
                })->values();

                $totalAngsuran = $penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran;
                $jumlahTerbayar = $angsuran->where('status_pembayaran', 'terbayar')->sum('jumlah_angsur');
                $sisaAngsuran = $totalAngsuran - $jumlahTerbayar;
            }
        }

        $html = view('laporan.kartu-piutang-pdf', compact('penjualanKredit', 'angsuran', 'jatuhTempo', 'statusPembayaran', 'sisaAngsuran'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('Kartu Piutang_' . ($penjualanKredit && $penjualanKredit->pelanggan ? $penjualanKredit->pelanggan->nama_pelanggan : 'undefined') . '.pdf', 'D');
        // return view('laporan.kartu-piutang-pdf', compact('penjualanKredit', 'angsuran', 'jatuhTempo', 'statusPembayaran', 'sisaAngsuran'));
    }

    public function cetakLaporanPiutang(Request $request)
    {
        Carbon::setLocale('id');
        $query = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur');

        if ($search = $request->input('search')) {
            $keyword = '%' . $search . '%';
            $query->whereHas('penjualanKredit.pelanggan', function ($q) use ($keyword) {
                $q->where('nama_pelanggan', 'like', $keyword);
            });
        }

        if ($filter = $request->input('filter-piutang')) {
            switch ($filter) {
                case 'az':
                    $query->orderBy('pelanggan.nama_pelanggan', 'asc');
                    break;
                case 'za':
                    $query->orderBy('pelanggan.nama_pelanggan', 'desc');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'selesai':
                    $query->where('status', 'selesai');
                    break;
                case 'berjalan':
                    $query->where('status', 'berjalan');
                    break;
            }
        }

        $piutang = $query->join('penjualan_kredit', 'angsuran.penjualan_kredit_id', '=', 'penjualan_kredit.id_penjualan_kredit')
            ->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
            ->select('angsuran.*')
            ->orderBy('tanggal_pembayaran', 'asc')
            ->get();

        // Hitung total kredit unik berdasarkan ID penjualan kredit
        $totalKredit = PenjualanKredit::with('angsuran')
            ->get()
            ->sum(function ($penjualanKredit) {
                return $penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran;
            });

        // Hitung total angsuran yang dibayarkan
        $totalAngsuran = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur')
            ->sum('jumlah_angsur');

        // Hitung total angsuran yang terutang
        $totalAngsuranTerutang = $totalKredit - $totalAngsuran;

        $html = view('laporan.piutang-pdf', compact('piutang', 'totalKredit', 'totalAngsuran', 'totalAngsuranTerutang'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('LAPORAN PIUTANG TOKO RAHAYU ELEKTRONIK.pdf', 'D');
        // return view('laporan.piutang-pdf', compact('piutang', 'totalKredit', 'totalAngsuran', 'totalAngsuranTerutang'));
    }

    public function cetakPenjualanTerlaris(Request $request)
    {
        Carbon::setLocale('id');
        $startDate = Carbon::parse($request->input('start'))->startOfDay();
        $endDate = Carbon::parse($request->input('end'))->endOfDay();

        $barangTerlaris = DetailPenjualanKredit::select(
            'barang.id_barang',
            'barang.nama_barang',
            'barang.merk',
            'barang.jenis',
            DB::raw('SUM(detail_penjualan_kredit.kuantitas) as total_terjual')
        )
            ->join('barang', 'detail_penjualan_kredit.barang_id', '=', 'barang.id_barang')
            ->whereHas('penjualanKredit', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tanggal_penjualan', [$startDate, $endDate]);
            })
            ->groupBy('barang.id_barang', 'barang.nama_barang', 'barang.merk', 'barang.jenis')
            ->orderByDesc('total_terjual')
            ->get();

        $html = view('laporan.penjualan-terlaris-pdf', compact('barangTerlaris', 'startDate', 'endDate'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('laporan-penjualan-terlaris-periode_' . \Carbon\Carbon::parse($startDate)->translatedFormat('d-F-Y') . '_' . \Carbon\Carbon::parse($endDate)->translatedFormat('d-F-Y') . '.pdf', 'D');
        // return view('laporan.penjualan-periode-pdf', compact('barangTerlaris', 'startDate', 'endDate'));
    }
}
