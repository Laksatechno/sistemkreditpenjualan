<?php

namespace App\Http\Controllers\page;

use Exception;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    public function index()
    {
        $query = Pelanggan::query();

        if ($search = request('search')) {
            $keyword = '%' . $search . '%';
            $query->where(function ($query) use ($keyword) {
                $query->where('nama_pelanggan', 'like', $keyword)
                    ->orWhere('alamat', 'like', $keyword)
                    ->orWhere('telepon', 'like', $keyword);
            });
        }

        if ($filter = request('filter-pelanggan')) {
            switch ($filter) {
                case 'az':
                    $query->orderBy('nama_pelanggan', 'asc');
                    break;
                case 'za':
                    $query->orderBy('nama_pelanggan', 'desc');
                    break;
            }
        }

        $pelanggan = $query->paginate(10);

        foreach ($pelanggan as $item) {
            if ($item->file_identitas) {
                $item->status_identitas = 'disertakan';
            } else {
                $item->status_identitas = 'tidak disertakan';
            }
        }

        return view('pelanggan.index', compact('pelanggan'));
    }


    public function create()
    {
        return view('pelanggan.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'telepon' => 'required|numeric',
            'kartu_identitas' => 'required|file|mimes:pdf|max:1024',
        ], [
            'nama_pelanggan.required' => 'Nama pelanggan tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'telepon.required' => 'Nomor telepon tidak boleh kosong',
            'telepon.numeric' => 'Nomor telepon harus berupa angka',
            'kartu_identitas.required' => 'Kartu identitas harus diunggah',
            'kartu_identitas.mimes' => 'Kartu identitas harus berformat .pdf',
            'kartu_identitas.max' => 'Ukuran file kartu identitas maksimal 1MB',
        ]);

        DB::beginTransaction();

        try {
            $pelanggan = Pelanggan::create([
                'nama_pelanggan' => $request->input('nama_pelanggan'),
                'alamat' => $request->input('alamat'),
                'telepon' => $request->input('telepon'),
            ]);

            if ($request->hasFile('kartu_identitas')) {
                $file = $request->file('kartu_identitas');
                $filename = $pelanggan->id_pelanggan . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/identitas', $filename);
                $pelanggan->file_identitas = $filename;
                $pelanggan->save();
            }

            DB::commit();

            return redirect()->route('pelanggan')->with('success', 'Pelanggan berhasil ditambahkan');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating pelanggan: ' . $e->getMessage());

            return redirect()->route('pelanggan.create')->with('error', 'Gagal menambahkan pelanggan');
        }
    }



    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.update', compact('pelanggan'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'file_identitas' => 'nullable|mimes:pdf|max:1024'
        ]);

        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->nama_pelanggan = $request->nama_pelanggan;
        $pelanggan->telepon = $request->telepon;
        $pelanggan->alamat = $request->alamat;

        if ($request->hasFile('file_identitas')) {
            if ($pelanggan->file_identitas) {
                Storage::delete('app/public/identitas/' . $pelanggan->file_identitas);
            }

            $file = $request->file('file_identitas');
            $fileName = $pelanggan->id_pelanggan . '.' . $file->getClientOriginalExtension();
            $file->storeAs('app/public/identitas', $fileName);
            $pelanggan->file_identitas = $fileName;
        }

        $pelanggan->save();

        return redirect()->route('pelanggan')->with('success', 'Data pelanggan berhasil diperbarui.');
    }


    public function destroy(string $id)
    {
        Log::info('Destroy method called for Pelanggan ID: ' . $id);

        $pelanggan = Pelanggan::findOrFail($id);

        DB::beginTransaction();

        try {
            // Hapus file identitas jika ada
            if ($pelanggan->file_identitas) {
                Storage::delete('public/identitas/' . $pelanggan->file_identitas);
            }

            // Hapus entitas Pelanggan
            $pelanggan->delete();

            DB::commit();

            return redirect()->route('pelanggan')->with('success', 'Pelanggan berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting pelanggan: ' . $e->getMessage());

            return redirect()->route('pelanggan')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function downloadIdentitas($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        if ($pelanggan->file_identitas) {
            $filename = $pelanggan->file_identitas;
            $path = storage_path('app/public/identitas/' . $filename);

            return response()->download($path);
        }

        return redirect()->back()->withErrors('File identitas tidak tersedia untuk diunduh.');
    }
}
