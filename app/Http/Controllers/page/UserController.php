<?php

namespace App\Http\Controllers\page;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function showResetPassword($id)
    {
        return view('profile.ganti-password', ['id' => $id]);
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_new_password' => 'required|min:8|same:new_password',
        ], [
            'old_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter',
            'confirm_new_password.required' => 'Konfirmasi password harus diisi',
            'confirm_new_password.min' => 'Konfirmasi password harus memiliki minimal 8 karakter',
            'confirm_new_password.same' => 'Konfirmasi password harus sama dengan password baru',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')->with('success', 'Password berhasil diubah');
    }
}
