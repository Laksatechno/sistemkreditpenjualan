@extends('layout.app')

@section('title', 'Beranda')

@section('content')

@if(Auth::user()->role === 'superadmin' || Auth::user()->role === 'manajer')
<div class="mb-8">
    <p class="text-xl text-gray-900 mb-2">Selamat Datang, <span class="font-medium capitalize">{{ Auth::user()->name }}</span>.</p>
    <p class="text-base text-gray-900">Anda masuk sebagai <span class="font-medium capitalize">{{ Auth::user()->role }}</span>.</p>
</div>
@endif

<div class="grid xl:grid-cols-4 md:grid-cols-2 gap-6">
    @if(Auth::user()->role === 'manajer')
    <a href="{{ route('barang') }}" class="rounded-lg border border-blue-500 bg-white hover:bg-blue-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Barang</p>

            <div class="bg-blue-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.583 8.445h.01M10.86 19.71l-6.573-6.63a.993.993 0 0 1 0-1.4l7.329-7.394A.98.98 0 0 1 12.31 4l5.734.007A1.968 1.968 0 0 1 20 5.983v5.5a.992.992 0 0 1-.316.727l-7.44 7.5a.974.974 0 0 1-1.384.001Z"/>
                </svg>
            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ $totalBarang }}</p>
    </a>

    <a href="{{ route('pelanggan') }}" class="rounded-lg border border-green-500 bg-white hover:bg-green-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Pelanggan</p>

            <div class="bg-green-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ $totalPelanggan }}</p>
    </a>

    <a href="{{ route('penjualan') }}" class="rounded-lg border border-yellow-300 bg-white hover:bg-yellow-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Penjualan</p>

            <div class="bg-amber-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-amber-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z" clip-rule="evenodd"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ 'Rp' . number_format($totalPenjualan, 0, ',', '.') }}</p>
    </a>

    <a href="{{ route('laporan.piutang') }}" class="rounded-lg border border-red-400 bg-white hover:bg-red-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Kredit</p>

            <div class="bg-red-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ 'Rp' . number_format($totalKredit, 0, ',', '.') }}</p>
    </a>

    <a href="{{ route('angsuran') }}" class="rounded-lg border border-red-400 bg-white hover:bg-red-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Kuantitas Angsuran</p>

            <div class="bg-red-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ $totalAngsuran }}</p>
    </a>

    <a href="{{ route('angsuran') }}" class="rounded-lg border border-amber-400 bg-white hover:bg-amber-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Kuantitas Angsuran Diterima</p>

            <div class="bg-amber-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-amber-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ $totalAngsuranDiterima }}</p>
    </a>

    <a href="{{ route('angsuran') }}" class="rounded-lg border border-green-400 bg-white hover:bg-green-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Kuantitas Angsuran Terutang</p>

            <div class="bg-green-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ $totalAngsuranTerutang }}</p>
    </a>

    <a href="{{ route('laporan.piutang') }}" class="rounded-lg border border-blue-400 bg-white hover:bg-blue-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Nominal Angsuran Dibayarkan</p>

            <div class="bg-blue-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ 'Rp' . number_format($totalNominalAngsuran, 0, ',', '.') }}</p>
    </a>

    <a href="{{ route('laporan.piutang') }}" class="rounded-lg border border-blue-400 bg-white hover:bg-blue-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Nominal Angsuran Terutang</p>

            <div class="bg-blue-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ 'Rp' . number_format($totalNominalAngsuranTerutang, 0, ',', '.') }}</p>
    </a>    
    @endif

    @if(Auth::user()->role === 'superadmin')
    <a href="{{ route('pengguna') }}" class="rounded-lg border border-green-500 bg-white hover:bg-green-50 p-4">
        <div class="flex items-center justify-between mb-2">
            <p class="text-gray-500 text-sm">Total Pengguna</p>

            <div class="bg-green-200 p-1 flex items-center justify-center rounded-full">
                <svg class="w-5 h-5 text-green-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                </svg>

            </div>
        </div>

        <p class="text-xl font-medium text-gray-700">{{ $totalUser }}</p>
    </a>
    @endif
</div>

@if(Auth::user()->role === 'karyawan')
<div class="mt-28 mb-8 text-center">
    <p class="text-2xl text-gray-900 mb-4">Selamat Datang, <span class="font-medium capitalize">{{ Auth::user()->name }}</span>. </p>
    <p class="text-xl text-gray-900">Anda masuk sebagai <span class="font-medium capitalize">{{ Auth::user()->role }}</span>.</p>
</div>
@endif

@endsection