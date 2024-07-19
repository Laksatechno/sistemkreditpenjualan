<?php

namespace App\Http\Controllers\page;

use Exception;
use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Barang::with('jenisBarang');

        if (request('search')) {
            $keyword = '%' . request('search') . '%';
            $query->where(function ($query) use ($keyword) {
                $query->where('nama_barang', 'like', $keyword)
                    ->orWhere('merk', 'like', $keyword)
                    ->orWhereHas('jenisBarang', function ($query) use ($keyword) {
                        $query->where('nama_jenis', 'like', $keyword);
                    });
            });
        } elseif (request('filter-barang')) {
            switch (request('filter-barang')) {
                case 'az':
                    $query->orderBy('nama_barang', 'asc');
                    break;
                case 'za':
                    $query->orderBy('nama_barang', 'desc');
                    break;
                case 'stok_terbanyak':
                    $query->orderBy('stok', 'desc');
                    break;
                case 'stok_sedikit':
                    $query->orderBy('stok', 'asc');
                    break;
                case 'harga_termahal':
                    $query->orderBy('harga', 'desc');
                    break;
                case 'harga_termurah':
                    $query->orderBy('harga', 'asc');
                    break;
                default:
                    break;
            }
        }

        $barang = $query->get();

        return view('barang.index', compact('barang'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jenisBarang = JenisBarang::all();
        return view('barang.create', compact('jenisBarang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jenis_id' => 'required',
            'merk' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric'
        ], [
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'jenis_id.required' => 'Jenis barang tidak boleh kosong',
            'merk.required' => 'Merk barang tidak boleh kosong',
            'stok.required' => 'Stok barang tidak boleh kosong',
            'stok.numeric' => 'Stok harus berupa angka',
            'satuan.required' => 'Satuan barang tidak boleh kosong',
            'harga.required' => 'Harga barang tidak boleh kosong',
            'harga.numeric' => 'Harga harus berupa angka',
        ]);

        DB::beginTransaction();

        try {
            $barang = Barang::updateOrCreate(
                [
                    'nama_barang' => $request->input('nama_barang'),
                    'jenis_id' => $request->input('jenis_id'),
                    'merk' => $request->input('merk'),
                    'satuan' => $request->input('satuan'),
                ],
                [
                    'stok' => DB::raw('stok + ' . $request->input('stok')),
                    'harga' => $request->input('harga'),
                ]
            );

            DB::commit();

            $message = $barang->wasRecentlyCreated ? 'Barang berhasil ditambahkan' : 'Data barang berhasil diupdate';
            return redirect()->route('barang')->with('success', $message);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating or updating barang: ' . $e->getMessage());

            return redirect()->route('barang.create')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::findOrFail($id);
        $jenisBarang = JenisBarang::all();
        return view('barang.update', compact('barang', 'jenisBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jenis_id' => 'required',
            'merk' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'harga' => 'required|numeric'
        ], [
            'nama_barang.required' => 'Nama barang tidak boleh kosong',
            'jenis_id.required' => 'Jenis barang tidak boleh kosong',
            'merk.required' => 'Merk barang tidak boleh kosong',
            'stok.required' => 'Stok barang tidak boleh kosong',
            'stok.numeric' => 'Stok harus berupa angka',
            'satuan.required' => 'Satuan barang tidak boleh kosong',
            'harga.required' => 'Harga barang tidak boleh kosong',
            'harga.numeric' => 'Harga harus berupa angka',
        ]);

        DB::beginTransaction();

        try {
            $barang = Barang::findOrFail($id);
            $barang->update([
                'nama_barang' => $request->input('nama_barang'),
                'jenis_id' => $request->input('jenis_id'),
                'merk' => $request->input('merk'),
                'stok' => $request->input('stok'),
                'satuan' => $request->input('satuan'),
                'harga' => $request->input('harga'),
            ]);

            DB::commit();

            return redirect()->route('barang')->with('success', 'Barang berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating barang: ' . $e->getMessage());

            return redirect()->route('barang.edit', $id)->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $barang = Barang::findOrFail($id);

        DB::beginTransaction();

        try {
            $barang->delete();

            DB::commit();

            return redirect()->route('barang')->with('success', 'Barang berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting barang: ', $e->getMessage());

            return redirect()->route('barang')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
