<?php

namespace App\Http\Controllers\page;

use Exception;
use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Angsuran;
use Illuminate\Http\Request;

use App\Models\PenjualanKredit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AngsuranController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('id');
        $query = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur');

        if ($request->has('filter-angsuran')) {
            $filter = $request->input('filter-angsuran');
            if ($filter == 'az') {
                $query->orderBy('pelanggan.nama_pelanggan', 'asc');
            } elseif ($filter == 'za') {
                $query->orderBy('pelanggan.nama_pelanggan', 'desc');
            }
        }

        if ($request->has('filter-date')) {
            $filterDate = $request->input('filter-date');
            if ($filterDate == 'terbaru') {
                $query->orderBy('angsuran.tanggal_pembayaran', 'desc');
            } elseif ($filterDate == 'terlama') {
                $query->orderBy('angsuran.tanggal_pembayaran', 'asc');
            }
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('penjualanKredit.pelanggan', function ($query) use ($searchTerm) {
                $query->where('nama_pelanggan', 'like', '%' . $searchTerm . '%');
            });
        }

        $angsuran = $query->join('penjualan_kredit', 'angsuran.penjualan_kredit_id', '=', 'penjualan_kredit.id_penjualan_kredit')
            ->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
            ->select('angsuran.*')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        return view('angsuran.index', compact('angsuran'));
    }


    public function create()
    {
        $penjualanKredits = PenjualanKredit::with('pelanggan')->get();
        return view('angsuran.create', compact('penjualanKredits'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_penjualan' => 'required|exists:penjualan_kredit,id_penjualan_kredit',
            'tanggal' => [
                'required',
                'date_format:m/d/Y',
                function ($attribute, $value, $fail) use ($request) {
                    $penjualanKredit = PenjualanKredit::findOrFail($request->id_penjualan);

                    if ($request->angsuran_ke == 1) {
                        $tanggalPenjualan = Carbon::parse($penjualanKredit->tanggal_penjualan);
                        $maxTanggal = $tanggalPenjualan->copy()->addDays(30);

                        $tanggalPembayaran = Carbon::createFromFormat('m/d/Y', $value);
                        if ($tanggalPembayaran->lessThan($tanggalPenjualan) || $tanggalPembayaran->greaterThan($maxTanggal)) {
                            $fail('Tanggal pembayaran untuk angsuran pertama harus antara ' . $tanggalPenjualan->translatedFormat('d F Y') . ' sampai ' . $maxTanggal->subDay()->translatedFormat('d F Y'));
                        }
                    } else {
                        $angsuranSebelumnya = Angsuran::where('penjualan_kredit_id', $request->id_penjualan)
                            ->where('no_angsur', $request->angsuran_ke - 1)
                            ->whereNotNull('tanggal_pembayaran')
                            ->first();

                        if (!$angsuranSebelumnya) {
                            $fail('Angsuran sebelumnya belum dibayar');
                        }

                        // Ubah tanggal_pembayaran menjadi objek Carbon
                        $tanggalPembayaran = Carbon::createFromFormat('m/d/Y', $value);
                        $tanggalSebelumnya = Carbon::parse($angsuranSebelumnya->tanggal_pembayaran);

                        $maxTanggal = $tanggalSebelumnya->copy()->addDays(30);

                        if ($tanggalPembayaran->lessThan($tanggalSebelumnya) || $tanggalPembayaran->greaterThan($maxTanggal)) {
                            $fail('Tanggal pembayaran harus antara ' . $tanggalSebelumnya->translatedFormat('d F Y') . ' sampai ' . $maxTanggal->subDay()->translatedFormat('d F Y'));
                        }
                    }
                },
            ],
            'angsuran_ke' => 'required|integer|min:1',
            'nominal' => 'required|numeric|min:0',
        ], [
            'id_penjualan.required' => 'ID Penjualan tidak boleh kosong',
            'id_penjualan.exists' => 'ID Penjualan tidak valid',
            'tanggal.required' => 'Tanggal pembayaran tidak boleh kosong',
            'tanggal.date_format' => 'Format tanggal tidak valid',
            'angsuran_ke.required' => 'Angsuran ke tidak boleh kosong',
            'angsuran_ke.integer' => 'Angsuran ke harus berupa angka',
            'angsuran_ke.min' => 'Angsuran ke minimal bernilai 1',
            'nominal.required' => 'Nominal tidak boleh kosong',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal bernilai 0',
        ]);

        $penjualanKredit = PenjualanKredit::findOrFail($request->id_penjualan);

        DB::beginTransaction();

        try {
            $totalJumlahAngsur = Angsuran::where('penjualan_kredit_id', $request->id_penjualan)
                ->sum('jumlah_angsur') + $request->nominal;

            $totalKredit = $penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran;

            if ($totalJumlahAngsur < $totalKredit) {
                $penjualanKredit->status = 'berjalan';
            } elseif ($totalJumlahAngsur >= $totalKredit) {
                $penjualanKredit->status = 'selesai';
            }
            $penjualanKredit->save();

            $angsuran = Angsuran::where('penjualan_kredit_id', $request->id_penjualan)
                ->whereNull('tanggal_pembayaran')
                ->whereNull('jumlah_angsur')
                ->whereNull('no_angsur')
                ->firstOrFail();

            $angsuran->penjualan_kredit_id = $request->id_penjualan;
            $angsuran->tanggal_pembayaran = Carbon::createFromFormat('m/d/Y', $request->tanggal)->format('Y-m-d');
            $angsuran->jumlah_angsur = $request->nominal;
            $angsuran->no_angsur = $request->angsuran_ke;
            $angsuran->save();

            DB::commit();

            return redirect()->route('angsuran')->with('success', 'Data angsuran berhasil ditambahkan');
        } catch (ValidationException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating/updating angsuran: ' . $e->getMessage());

            return redirect()->route('angsuran.create')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit(string $id)
    {
        try {
            $angsuran = Angsuran::findOrFail($id);
            $penjualanKredits = PenjualanKredit::with('pelanggan')->get();

            return view('angsuran.update', compact('angsuran', 'penjualanKredits'));
        } catch (Exception $e) {
            Log::error('Error fetching angsuran: ' . $e->getMessage());
            return redirect()->route('angsuran')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_penjualan' => 'required|exists:penjualan_kredit,id_penjualan_kredit',
            'tanggal' => 'required|date',
            'angsuran_ke' => 'required|integer|min:1',
            'nominal' => 'required|numeric|min:0',
        ], [
            'id_penjualan.required' => 'ID Penjualan tidak boleh kosong',
            'id_penjualan.exists' => 'ID Penjualan tidak valid',
            'tanggal.required' => 'Tanggal pembayaran tidak boleh kosong',
            'tanggal.date' => 'Format tanggal tidak valid',
            'angsuran_ke.required' => 'Angsuran ke tidak boleh kosong',
            'angsuran_ke.integer' => 'Angsuran ke harus berupa angka',
            'angsuran_ke.min' => 'Angsuran ke minimal bernilai 1',
            'nominal.required' => 'Nominal tidak boleh kosong',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal bernilai 0',
        ]);

        $penjualanKredit = PenjualanKredit::findOrFail($request->id_penjualan);

        if ($request->nominal < $penjualanKredit->total_angsur_bulanan) {
            return redirect()->back()->withErrors(['nominal' => 'Nominal angsuran harus sama dengan total angsur bulanan.'])->withInput();
        }

        DB::beginTransaction();

        try {
            $angsuran = Angsuran::findOrFail($id);

            $angsuran->penjualan_kredit_id = $request->id_penjualan;
            $angsuran->tanggal_pembayaran = Carbon::createFromFormat('m/d/Y', $request->tanggal)->format('Y-m-d');
            $angsuran->jumlah_angsur = $request->nominal;
            $angsuran->no_angsur = $request->angsuran_ke;
            $angsuran->save();

            DB::commit();

            return redirect()->route('angsuran')->with('success', 'Data angsuran berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating angsuran: ' . $e->getMessage());

            return redirect()->route('angsuran.edit', $id)->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        $angsuran = Angsuran::findOrFail($id);

        DB::beginTransaction();

        try {
            $totalJumlahAngsur = Angsuran::where('penjualan_kredit_id', $angsuran->penjualan_kredit_id)
                ->sum('jumlah_angsur') - $angsuran->jumlah_angsur;

            $penjualanKredit = PenjualanKredit::where('id_penjualan_kredit', $angsuran->penjualan_kredit_id)->firstOrFail();
            $totalKredit = $penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran;

            if ($totalJumlahAngsur < $totalKredit) {
                $penjualanKredit->status = 'berjalan';
            } elseif ($totalJumlahAngsur >= $totalKredit) {
                $penjualanKredit->status = 'selesai';
            }
            $penjualanKredit->save();

            // Update field-field menjadi null
            $angsuran->tanggal_pembayaran = null;
            $angsuran->jumlah_angsur = null;
            $angsuran->no_angsur = null;
            $angsuran->save();

            DB::commit();

            return redirect()->route('angsuran')->with('success', 'Data angsuran berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating angsuran: ' . $e->getMessage());

            return redirect()->route('angsuran')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function getRemainingAngsuran($id)
    {
        $angsuranTerisi = Angsuran::where('penjualan_kredit_id', $id)
            ->whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur')
            ->whereNotNull('no_angsur')
            ->pluck('no_angsur')
            ->toArray();

        return response()->json($angsuranTerisi);
    }

    public function cetakDataAngsuran(Request $request)
    {
        Carbon::setLocale('id');
        $query = Angsuran::whereNotNull('tanggal_pembayaran')
            ->whereNotNull('jumlah_angsur');

        if ($request->has('filter-angsuran')) {
            $filter = $request->input('filter-angsuran');
            if ($filter == 'az') {
                $query->orderBy('pelanggan.nama_pelanggan', 'asc');
            } elseif ($filter == 'za') {
                $query->orderBy('pelanggan.nama_pelanggan', 'desc');
            }
        }

        if ($request->has('filter-date')) {
            $filterDate = $request->input('filter-date');
            if ($filterDate == 'terbaru') {
                $query->orderBy('angsuran.tanggal_pembayaran', 'desc');
            } elseif ($filterDate == 'terlama') {
                $query->orderBy('angsuran.tanggal_pembayaran', 'asc');
            }
        }

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->whereHas('penjualanKredit.pelanggan', function ($query) use ($searchTerm) {
                $query->where('nama_pelanggan', 'like', '%' . $searchTerm . '%');
            });
        }

        $angsuran = $query->join('penjualan_kredit', 'angsuran.penjualan_kredit_id', '=', 'penjualan_kredit.id_penjualan_kredit')
            ->join('pelanggan', 'penjualan_kredit.pelanggan_id', '=', 'pelanggan.id_pelanggan')
            ->select('angsuran.*')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();

        $html = view('angsuran.cetak', compact('angsuran'))->render();

        $mpdf = new Mpdf([
            'orientation' => 'L'
        ]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('laporan-angsuran-pelanggan.pdf', 'D');
        // return view('angsuran.cetak', compact('angsuran'));
    }
}
