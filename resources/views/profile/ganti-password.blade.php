@extends('layout.app')

@section('title', 'Ganti Password')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Ubah Password</span>
</div>

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('gantiPassword.update', Auth::user()->user_id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="old_password" class="block mb-2 text-base font-medium text-gray-900">Password Lama</label>
                <div class="relative">
                    <input type="password" name="old_password" id="old_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10">
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600" onclick="toggleOldPassword()">
                        <svg id="show-icon-old" class="w-5 h-5 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="hide-icon-old" class="w-5 h-5 text-gray-600 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                </div>
                @error('old_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <hr class="mb-4">

        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="new_password" class="block mb-2 text-base font-medium text-gray-900">Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10">
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600" onclick="toggleNewPassword()">
                        <svg id="show-icon-new" class="w-5 h-5 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="hide-icon-new" class="w-5 h-5 text-gray-600 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                </div>
                @error('new_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="confirm_new_password" class="block mb-2 text-base font-medium text-gray-900">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10">
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600" onclick="toggleConfirmNewPassword()">
                        <svg id="show-icon-confirm" class="w-5 h-5 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                            <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <svg id="hide-icon-confirm" class="w-5 h-5 text-gray-600 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                    </button>
                </div>
                @error('confirm_new_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Ubah Password</button>
            <a href="{{ route('home') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>


<script>
    function toggleOldPassword() {
        const passwordInput = document.getElementById('old_password');
        const showIconOld = document.getElementById('show-icon-old');
        const hideIconOld = document.getElementById('hide-icon-old');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIconOld.classList.add('hidden');
            hideIconOld.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            showIconOld.classList.remove('hidden');
            hideIconOld.classList.add('hidden');
        }
    }

    function toggleNewPassword() {
        const passwordInput = document.getElementById('new_password');
        const showIconNew = document.getElementById('show-icon-new');
        const hideIconNew = document.getElementById('hide-icon-new');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIconNew.classList.add('hidden');
            hideIconNew.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            showIconNew.classList.remove('hidden');
            hideIconNew.classList.add('hidden');
        }
    }

    function toggleConfirmNewPassword() {
        const passwordInput = document.getElementById('confirm_new_password');
        const showIconConfirm = document.getElementById('show-icon-confirm');
        const hideIconConfirm = document.getElementById('hide-icon-confirm');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            showIconConfirm.classList.add('hidden');
            hideIconConfirm.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            showIconConfirm.classList.remove('hidden');
            hideIconConfirm.classList.add('hidden');
        }
    }
</script>
@endsection