<?php

namespace App\Http\Controllers\page;

use Exception;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Barang;

use App\Models\Angsuran;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\PenjualanKredit;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\DetailPenjualanKredit;

class PenjualanKreditController extends Controller
{
    public function index()
    {
        Carbon::setLocale('id');
        $query = PenjualanKredit::with(['pelanggan', 'detailPenjualanKredit.barang', 'angsuran']);

        if ($search = request('search')) {
            $keyword = '%' . $search . '%';
            $query->whereHas('pelanggan', function ($q) use ($keyword) {
                $q->where('nama_pelanggan', 'like', $keyword);
            })->orWhereHas('detailPenjualanKredit.barang', function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', $keyword);
            });
        }

        if ($filter = request('filter-penjualan')) {
            switch ($filter) {
                case 'az':
                    $query->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
                        ->orderBy('pelanggan.nama_pelanggan', 'asc')
                        ->select('penjualan_kredit.*');
                    break;
                case 'za':
                    $query->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
                        ->orderBy('pelanggan.nama_pelanggan', 'desc')
                        ->select('penjualan_kredit.*');
                    break;
                case 'terbaru':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'termahal':
                    $query->orderBy('total_harga', 'desc');
                    break;
                case 'termurah':
                    $query->orderBy('total_harga', 'asc');
                    break;
            }
        }

        $penjualan = $query->paginate(10);

        return view('penjualan.index', compact('penjualan'));
    }


    public function create()
    {
        $pelanggans = Pelanggan::all();
        $barangs = Barang::all();
        return view('penjualan.create', compact('pelanggans', 'barangs'));
    }


    public function store(Request $request)
    {
        $request->validate(
            [
                'tanggal_penjualan' => 'required',
                'pelanggan' => 'required|exists:pelanggan,id_pelanggan',
                'barangs.*.id' => 'required|exists:barang,id_barang',
                'barangs.*.kuantitas' => 'required|numeric|min:1',
                'down_payment' => 'required|numeric',
                'jangka_pembayaran' => 'required|numeric|min:1'
            ],
            [
                'tanggal_penjualan.required' => 'Tanggal penjualan tidak boleh kosong',
                'pelanggan.required' => 'Nama pelanggan tidak boleh kosong',
                'pelanggan.exists' => 'Nama pelanggan tidak ada dalam database',
                'barangs.*.id.required' => 'Barang tidak boleh kosong',
                'barangs.*.id.exists' => 'Barang tidak ada dalam database',
                'barangs.*.kuantitas.required' => 'Kuantitas penjualan tidak boleh kosong',
                'barangs.*.kuantitas.numeric' => 'Kuantitas harus berupa angka',
                'barangs.*.kuantitas.min' => 'Minimal kuantitas adalah 1',
                'down_payment.required' => 'Uang muka tidak boleh kosong',
                'down_payment.numeric' => 'Uang muka harus berupa angka',
                'jangka_pembayaran.required' => 'Jangka pembayaran tidak boleh kosong',
                'jangka_pembayaran.numeric' => 'Jangka pembayaran harus berupa angka',
                'jangka_pembayaran.min' => 'Minimal jangka pembayaran adalah 1',
            ]
        );

        $tanggal_penjualan = Carbon::createFromFormat('m/d/Y', $request->tanggal_penjualan)->format('Y-m-d');

        $total_harga = 0;
        $barangs = [];

        if ($request->has('barangs')) {
            foreach ($request->barangs as $key => $barang) {
                $barangModel = Barang::findOrFail($barang['id']);
                $kuantitas = $barang['kuantitas'];
                $sub_total = $barangModel->harga * $kuantitas;
                $total_harga += $sub_total;
                $barangs[] = [
                    'barang_id' => $barang['id'],
                    'kuantitas' => $kuantitas,
                    'harga_satuan' => $barangModel->harga,
                    'sub_total' => $sub_total
                ];
            }
        }

        $min_down_payment = $total_harga * 0.10;
        if ($request->down_payment < $min_down_payment) {
            return redirect()->back()->withErrors(['down_payment' => 'Minimal uang muka adalah 10% dari total harga.']);
        }

        $sisa_angsur = $total_harga - $request->down_payment;
        $bunga = $sisa_angsur * 0.02;
        $total_angsur_bulanan = ($sisa_angsur / $request->jangka_pembayaran) + $bunga;

        DB::beginTransaction();

        try {
            $penjualanKredit = PenjualanKredit::create([
                'pelanggan_id' => $request->pelanggan,
                'tanggal_penjualan' => $tanggal_penjualan,
                'total_harga' => $total_harga,
                'sisa_angsur' => $sisa_angsur,
                'down_payment' => $request->down_payment,
                'bunga' => $bunga,
                'jangka_pembayaran' => $request->jangka_pembayaran,
                'total_angsur_bulanan' => $total_angsur_bulanan,
                'status' => 'berjalan'
            ]);

            foreach ($barangs as $barang) {
                DetailPenjualanKredit::create([
                    'penjualan_kredit_id' => $penjualanKredit->id_penjualan_kredit,
                    'barang_id' => $barang['barang_id'],
                    'kuantitas' => $barang['kuantitas'],
                    'harga_satuan' => $barang['harga_satuan'],
                    'sub_total' => $barang['sub_total']
                ]);

                // Update the stock
                $barangModel = Barang::findOrFail($barang['barang_id']);
                $barangModel->stok -= $barang['kuantitas'];
                $barangModel->save();
            }

            for ($i = 1; $i <= $request->jangka_pembayaran; $i++) {
                Angsuran::create([
                    'penjualan_kredit_id' => $penjualanKredit->id_penjualan_kredit
                ]);
            }

            DB::commit();

            return redirect()->route('penjualan.show', $penjualanKredit->id_penjualan_kredit);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating penjualan kredit: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }




    public function show(string $id)
    {
        Carbon::setLocale('id');

        $penjualan = PenjualanKredit::with(['pelanggan', 'detailPenjualanKredit.barang'])->findOrFail($id);
        return view('penjualan.show', compact('penjualan'));
    }


    public function edit(string $id)
    {
        $penjualan = PenjualanKredit::with('detailPenjualanKredit')->findOrFail($id);
        $penjualan->tanggal_penjualan = Carbon::parse($penjualan->tanggal_penjualan)->format('m/d/Y');

        $pelanggans = Pelanggan::all();
        $barangs = Barang::all();

        return view('penjualan.update', compact('penjualan', 'pelanggans', 'barangs'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_penjualan' => 'required',
            'pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'barang' => 'required|exists:barang,id_barang',
            'kuantitas' => 'required|numeric|min:1',
            'down_payment' => 'required|numeric',
            'jangka_pembayaran' => 'required|numeric|min:1'
        ], [
            'tanggal_penjualan.required' => 'Tanggal penjualan tidak boleh kosong',
            'pelanggan.required' => 'Nama pelanggan tidak boleh kosong',
            'pelanggan.exists' => 'Nama pelanggan tidak ada dalam database',
            'barang.required' => 'Barang tidak boleh kosong',
            'barang.exists' => 'Barang tidak ada dalam database',
            'kuantitas.required' => 'Kuantitas penjualan tidak boleh kosong',
            'kuantitas.numeric' => 'Kuantitas harus berupa angka',
            'kuantitas.min' => 'Minimal kuantitas adalah 1',
            'down_payment.required' => 'Uang muka tidak boleh kosong',
            'down_payment.numeric' => 'Uang muka harus berupa angka',
            'jangka_pembayaran.required' => 'Jangka pembayaran tidak boleh kosong',
            'jangka_pembayaran.numeric' => 'Jangka pembayaran harus berupa angka',
            'jangka_pembayaran.min' => 'Minimal jangka pembayaran adalah 1',
        ]);

        $tanggal_penjualan = Carbon::createFromFormat('m/d/Y', $request->tanggal_penjualan)->format('Y-m-d');

        $barang = Barang::findOrFail($request->barang);
        $total_harga = $barang->harga * $request->kuantitas;

        $min_down_payment = $total_harga * 0.10;
        if ($request->down_payment < $min_down_payment) {
            return redirect()->back()->withErrors(['down_payment' => 'Minimal uang muka adalah 10% dari total harga.']);
        }

        $sisa_angsur = $total_harga - $request->down_payment;
        $bunga = $sisa_angsur * 0.02;
        $total_angsur_bulanan = ($sisa_angsur / $request->jangka_pembayaran) + $bunga;

        DB::beginTransaction();

        try {
            $penjualanKredit = PenjualanKredit::findOrFail($id);
            $penjualanKredit->update([
                'pelanggan_id' => $request->pelanggan,
                'tanggal_penjualan' => $tanggal_penjualan,
                'total_harga' => $total_harga,
                'sisa_angsur' => $sisa_angsur,
                'down_payment' => $request->down_payment,
                'bunga' => $bunga,
                'jangka_pembayaran' => $request->jangka_pembayaran,
                'total_angsur_bulanan' => $total_angsur_bulanan,
                'status' => 'berjalan'
            ]);

            $penjualanKredit->detailPenjualanKredit()->update([
                'barang_id' => $request->barang,
                'kuantitas' => $request->kuantitas,
                'harga_satuan' => $barang->harga,
                'sub_total' => $total_harga
            ]);

            DB::commit();

            return redirect()->route('penjualan.show', $penjualanKredit->id_penjualan_kredit);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating penjualan kredit: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }


    public function destroy(string $id)
    {
        $penjualan = PenjualanKredit::findOrFail($id);

        DB::beginTransaction();

        try {
            $penjualan->delete();

            DB::commit();

            return redirect()->route('penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting penjualan: ' . $e->getMessage());

            return redirect()->route('penjualan')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF($id)
    {
        Carbon::setLocale('id');
        $penjualan = PenjualanKredit::with(['pelanggan', 'detailPenjualanKredit.barang'])->findOrFail($id);

        $html = view('penjualan.faktur', compact('penjualan'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'P'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('faktur_' . sprintf('%06d', $penjualan->id_penjualan_kredit) . '_' . $penjualan->pelanggan->nama_pelanggan . '.pdf', 'D');
        // return view('penjualan.faktur', compact('penjualan'));
    }
}
