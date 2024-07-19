@extends('auth.app')

@section('title', 'Register')

@section('content')
<section class="bg-gray-50">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">

        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-center text-gray-900 p-4 pb-10">
                    Pendaftaran Akun
                </h1>

                <form class="space-y-4" action="{{ route('register') }}" method="POST">
                    @csrf

                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Masukkan nama anda">
                        @error('name')
                        <span class="text-sm text-red-500 py-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="text" name="email" id="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                            placeholder="Masukkan email anda">
                        @error('email')
                        <span class="text-sm text-red-500 py-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
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
                            <span class="text-sm text-red-500 py-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10">
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600" onclick="togglePasswordConfirmation()">
                                <svg id="show-icon-confirm" class="w-5 h-5 text-gray-600 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                    <path stroke="currentColor" stroke-width="2" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                                <svg id="hide-icon-confirm" class="w-5 h-5 text-gray-600 dark:text-white hidden" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.933 13.909A4.357 4.357 0 0 1 3 12c0-1 4-6 9-6m7.6 3.8A5.068 5.068 0 0 1 21 12c0 1-3 6-9 6-.314 0-.62-.014-.918-.04M5 19 19 5m-4 7a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                </svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <span class="text-sm text-red-500 py-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-8">
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Daftar
                        </button>
                    </div>

                    <div class="pb-4">
                        <p class="text-sm font-light text-gray-500">
                            Sudah memiliki akun? <a href="{{ route('login') }}"
                                class="font-medium text-blue-600 hover:underline">Masuk</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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

    function togglePasswordConfirmation() {
        const passwordInput = document.getElementById('password_confirmation');
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
