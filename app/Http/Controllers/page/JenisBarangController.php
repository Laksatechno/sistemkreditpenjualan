<?php

namespace App\Http\Controllers\page;

use Exception;
use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class JenisBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = JenisBarang::query();

        if (request('filter-jenis')) {
            switch (request('filter-jenis')) {
                case 'az':
                    $query->orderBy('nama_jenis', 'asc');
                    break;
                case 'za':
                    $query->orderBy('nama_jenis', 'desc');
                    break;
                default:
                    break;
            }
        } elseif ($search = request('search')) {
            $keyword = '%' . $search . '%';
            $query->where(function ($query) use ($keyword) {
                $query->where('nama_jenis', 'like', $keyword);
            });
        }

        $jenisBarang = $query->get();

        return view('jenis-barang.index', compact('jenisBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ], [
            'nama_jenis.required' => 'Nama jenis tidak boleh kosong',
        ]);

        DB::beginTransaction();

        try {
            JenisBarang::create([
                'nama_jenis' => $request->input('nama_jenis'),
            ]);

            DB::commit();

            return redirect()->route('jenis-barang')->with('success', 'Data jenis barang berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating jenis barang: ' . $e->getMessage());

            return redirect()->route('jenis-barang.create')->with('error', 'Gagal menambahkan data jenis barang');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);
        return view('jenis-barang.update', compact('jenisBarang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jenis' => 'required',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan tidak boleh kosong',
        ]);

        DB::beginTransaction();

        try {
            $jenisBarang = JenisBarang::findOrFail($id);
            $jenisBarang->update([
                'nama_jenis' => $request->input('nama_jenis'),
            ]);

            DB::commit();

            return redirect()->route('jenis-barang')->with('success', 'Data jenis barang berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating jenis barang: ' . $e->getMessage());

            return redirect()->route('jenis-barang.edit', $id)->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jenisBarang = JenisBarang::findOrFail($id);

        DB::beginTransaction();

        try {
            $jenisBarang->delete();

            DB::commit();

            return redirect()->route('jenis-barang')->with('success', 'Jenis barang berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting jenis barang: ', $e->getMessage());

            return redirect()->route('jenis-barang')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
