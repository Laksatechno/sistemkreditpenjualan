@extends('layout.app')

@section('title', 'Tambah User')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Tambah User</span>
</div>

@if ($message = Session::get('error'))
    <div class="flex items-center justify-center my-8">
        <p class="text-red-700 bg-red-100 py-2.5 px-5 rounded-lg">
           <span class="font-medium">{{ $message }}</span>. Silahkan coba lagi nanti.
        </p>
    </div>
@endif

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('pengguna.store') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="name" class="block mb-2 text-base font-medium text-gray-900">Nama Pengguna</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan nama pelanggan" />
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block mb-2 text-base font-medium text-gray-900">Email</label>
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan email"/>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block mb-2 text-base font-medium text-gray-900">Password</label>
                <div class="relative">
                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10">
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600" onclick="togglePassword()">
                        <svg id="show-icon" class="w-5 h-5 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="hide-icon" class="w-5 h-5 text-gray-600 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="role" class="block mb-2 text-base font-medium text-gray-900">Role</label>
                <select id="role" name="role" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled selected>Pilih role</option>
                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                    <option value="manajer" {{ old('role') == 'manajer' ? 'selected' : '' }}>Manajer</option>
                    <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
                @error('role')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tambah</button>
            <a href="{{ route('pelanggan') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const showIcon = document.getElementById('show-icon');
        const hideIcon = document.getElementById('hide-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIcon.classList.add('hidden');
            hideIcon.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            showIcon.classList.remove('hidden');
            hideIcon.classList.add('hidden');
        }
    }
</script>

@endsection
