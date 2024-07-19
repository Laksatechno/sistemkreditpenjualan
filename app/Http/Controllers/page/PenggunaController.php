<?php

namespace App\Http\Controllers\page;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $query = User::query();

        if ($search = request('search')) {
            $keyword = '%' . $search . '%';
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'like', $keyword)
                    ->orWhere('email', 'like', $keyword)
                    ->orWhere('role', 'like', $keyword);
            });
        }

        if ($filter = request('filter-pengguna')) {
            switch ($filter) {
                case 'az':
                    $query->orderBy('name', 'asc');
                    break;
                case 'za':
                    $query->orderBy('name', 'desc');
                    break;
            }
        }

        $pengguna = $query->paginate(10);

        foreach ($pengguna as $item) {
            if ($item->file_identitas) {
                $item->status_identitas = 'disertakan';
            } else {
                $item->status_identitas = 'tidak disertakan';
            }
        }

        return view('pengguna.index', compact('pengguna'));
    }


    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required'],
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama hanya boleh diisi maksimal 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.string' => 'Email hanya kombinasi huruf, angka, dan simbol',
            'email.email' => 'Format penulisan email salah',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password berupa kombinasi huruf, angka, dan simbol',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'role.required' => 'Role tidak boleh kosong',
        ]);

        DB::beginTransaction();

        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role'),
            ]);

            DB::commit();

            return redirect()->route('pengguna')->with('success', 'Data user berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating pengguna: ' . $e->getMessage());

            return redirect()->route('pengguna.create')->with('error', 'Gagal menambahkan user');
        }
    }


    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $pengguna = User::findOrFail($id);
        return view('pengguna.update', compact('pengguna'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:8'],
            'role' => ['required'],
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.max' => 'Nama hanya boleh diisi maksimal 255 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format penulisan email salah',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password harus memiliki minimal 8 karakter',
            'role.required' => 'Role tidak boleh kosong',
        ]);

        DB::beginTransaction();

        try {
            $pengguna = User::findOrFail($id);
            $pengguna->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role'),
            ]);

            DB::commit();

            return redirect()->route('pengguna')->with('success', 'Data pengguna berhasil diperbarui');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating pengguna: ' . $e->getMessage());

            return redirect()->route('pengguna.edit', $id)->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $pengguna = User::findOrFail($id);

        DB::beginTransaction();

        try {
            $pengguna->delete();

            DB::commit();

            return redirect()->route('pengguna')->with('success', 'Data pengguna berhasil dihapus');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting pengguna: ', $e->getMessage());

            return redirect()->route('pengguna')->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
