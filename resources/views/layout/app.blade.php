<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title> @yield('title')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <style>
        .datepicker {
            border: 1px solid #e5e7eb;
            border-radius: 5px;
            margin-top: 10px;
        }

        .penjualan {
            table, th, td, tr {
                --tw-text-opacity: 1;
                border: 1px solid;
                border-color: rgb(17 24 39 / var(--tw-text-opacity));
                border-collapse: collapse;
            }
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.min.js"></script>
</head>

<body>    
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">

                <div class="flex items-center justify-start">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:focus:ring-gray-600">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>

                    <a href="" class="flex ms-2 md:me-24">
                        <span class="self-center text-xl font-semibold sm:text-xl text-blue-600 hover:text-blue-700">Rahayu Elektronik</span>
                    </a>
                </div>

                <div class="flex items-center md:order-2 space-x-1 md:space-x-0 rtl:space-x-reverse">
                    <div class="flex justify-between items-center">
                        <img src="{{ asset('/img/icons/profile.webp') }}" alt="" class="w-9 h-9 rounded-full">
                        <div>
                            <div class="text-sm ms-2 font-medium">
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <div class="text-xs ms-2">
                                <span>{{ Auth::user()->role }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-30 w-64 h-screen mt-4 pt-16 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
            <div class="px-2 pb-2">
                <span class="font-medium text-sm text-gray-400">HALAMAN </span>
            </div>
            <ul class="space-y-2 font-medium">
                @php
                    $isActiveBeranda = request()->routeIs('home*');
                    $isActiveBarang = request()->routeIs('barang*');
                    $isActiveJenisBarang = request()->routeIs('jenis-barang*');
                    $isActivePelanggan = request()->routeIs('pelanggan*');
                    $isActivePenjualan = request()->routeIs('penjualan*');
                    $isActivePengguna = request()->routeIs('pengguna*');
                    $isActiveAngsuran = request()->routeIs('angsuran*');
                    $isActiveLaporan = request()->routeIs('laporan*');
                    $isActiveLaporanAngsuranPelanggan = request()->routeIs('laporan.angsuranPelanggan');
                    $isActiveLaporanAngsuranPeriode = request()->routeIs('laporan.angsuranPeriode');
                    $isActiveLaporanPenjualanPelanggan = request()->routeIs('laporan.penjualanPelanggan');
                    $isActiveLaporanPenjualanPeriode = request()->routeIs('laporan.penjualanPeriode');
                    $isActiveLaporanPenjualanTerlaris = request()->routeIs('laporan.penjualanTerlaris');
                    $isActiveKartuPiutang = request()->routeIs('kartuPiutang*');
                @endphp

                @if(Auth::user()->role === 'superadmin' || Auth::user()->role === 'karyawan' || Auth::user()->role === 'manajer')
                <li>
                    <a href="{{ route('home') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActiveBeranda ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ $isActiveBeranda ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                        </svg>
                        <span class="ms-3">Beranda</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role === 'karyawan')
                <li>
                    <a href="{{ route('barang') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActiveBarang ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 {{ $isActiveBarang ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.583 8.445h.01M10.86 19.71l-6.573-6.63a.993.993 0 0 1 0-1.4l7.329-7.394A.98.98 0 0 1 12.31 4l5.734.007A1.968 1.968 0 0 1 20 5.983v5.5a.992.992 0 0 1-.316.727l-7.44 7.5a.974.974 0 0 1-1.384.001Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Barang</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role === 'karyawan')
                <li>
                    <a href="{{ route('jenis-barang') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActiveJenisBarang ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 {{ $isActiveJenisBarang ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.2 6H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11.2a1 1 0 0 0 .747-.334l4.46-5a1 1 0 0 0 0-1.332l-4.46-5A1 1 0 0 0 15.2 6Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Jenis Barang</span>
                    </a>
                </li>
                @endif

                @if( Auth::user()->role === 'karyawan')
                <li>
                    <a href="{{ route('pelanggan') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActivePelanggan ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ $isActivePelanggan ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z" clip-rule="evenodd"/>
                        </svg>

                        <span class="flex-1 ms-3 whitespace-nowrap">Pelanggan</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role === 'karyawan')
                <li>
                    <a href="{{ route('penjualan') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActivePenjualan ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75s group-hover:text-gray-900 {{ $isActivePenjualan ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Penjualan</span>
                    </a>
                </li>                
                @endif

                @if(Auth::user()->role === 'superadmin')
                <li>
                    <a href="{{ route('pengguna') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActivePengguna ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 group-hover:text-gray-900 {{ $isActivePengguna ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12h4m-2 2v-4M4 18v-1a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v1a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1Zm8-10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Pengguna</span>
                    </a>
                </li>                
                @endif
                
                @if(Auth::user()->role === 'karyawan')
                <li class="bottom">
                    <a href="{{ route('angsuran') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActiveAngsuran ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 {{ $isActiveAngsuran ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Angsuran</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role === 'manajer' || Auth::user()->role === 'karyawan')
                <li>
                    <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveLaporan ? 'bg-gray-100' : '' }}" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-900 {{ $isActiveLaporan ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M9 7V2.221a2 2 0 0 0-.5.365L4.586 6.5a2 2 0 0 0-.365.5H9Zm2 0V2h7a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9h5a2 2 0 0 0 2-2Zm2-2a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm0 3a1 1 0 1 0 0 2h3a1 1 0 1 0 0-2h-3Zm-6 4a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v6a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-6Zm8 1v1h-2v-1h2Zm0 3h-2v1h2v-1Zm-4-3v1H9v-1h2Zm0 3H9v1h2v-1Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Laporan</span>
                        <svg class="w-3 h-3 text-gray-500 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">
                        <li>
                            <button type="button" class="flex items-center justify-between w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100" aria-controls="dropdown-angsuran" data-collapse-toggle="dropdown-angsuran">Angsuran
                                <svg class="w-3 h-3 text-gray-500 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <ul id="dropdown-angsuran" class="hidden py-2 space-y-2 pl-11">
                                <li>
                                    <a href="{{ route('laporan.angsuranPelanggan') }}" class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveLaporanAngsuranPelanggan ? 'bg-gray-100' : '' }}">Per Pelanggan</a>
                                </li>
                                <li>
                                    <a href="{{ route('laporan.angsuranPeriode') }}" class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveLaporanAngsuranPeriode ? 'bg-gray-100' : '' }}">Per Periode</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ route('laporan.piutang') }}" class="flex items-center justify-between w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100">Piutang</a>
                        </li>
                        
                        <li>
                            <button type="button" class="flex items-center justify-between w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100" aria-controls="dropdown-kartu-piutang" data-collapse-toggle="dropdown-kartu-piutang">Penjualan
                                <svg class="w-3 h-3 text-gray-500 group-hover:text-gray-900" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                                </svg>
                            </button>
                            <ul id="dropdown-kartu-piutang" class="hidden py-2 space-y-2 pl-11">
                                <li>
                                    <a href="{{ route('laporan.penjualanPelanggan') }}" class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveLaporanPenjualanPelanggan ? 'bg-gray-100' : '' }}">Per Pelanggan</a>
                                </li>
                                <li>
                                    <a href="{{ route('laporan.penjualanPeriode') }}" class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveLaporanPenjualanPeriode ? 'bg-gray-100' : '' }}">Per Periode</a>
                                </li>
                                <li>
                                    <a href="{{ route('laporan.penjualanTerlaris') }}" class="flex items-center w-full p-2 text-gray-700 transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveLaporanPenjualanTerlaris ? 'bg-gray-100' : '' }}">Terlaris</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endif

                @if(Auth::user()->role === 'manajer')
                <li class="bottom">
                    <a href="{{ route('kartuPiutang') }}""
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group {{ $isActiveKartuPiutang ? 'bg-gray-100' : '' }}">
                        <svg class="w-5 h-5 text-gray-500 {{ $isActiveKartuPiutang ? 'text-gray-900' : 'text-gray-500' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M16.5 15v1.5m0 0V18m0-1.5H15m1.5 0H18M3 9V6a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v3M3 9v6a1 1 0 0 0 1 1h5M3 9h16m0 0v1M6 12h3m12 4.5a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Kartu Piutang</span>
                    </a>
                </li>
                @endif
            </ul>

            <div class="px-2 pb-2 mt-6">
                <span class="font-medium text-sm text-gray-400">PENGATURAN</span>
            </div>

            <ul class="space-y-2 font-medium">
                @if(Auth::user()->role === 'superadmin' || Auth::user()->role === 'karyawan' || Auth::user()->role === 'manajer')
                <li>
                    <a href="{{ route('gantiPassword', Auth::user()->user_id) }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-900 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a28.076 28.076 0 0 1-1.091 9M7.231 4.37a8.994 8.994 0 0 1 12.88 3.73M2.958 15S3 14.577 3 12a8.949 8.949 0 0 1 1.735-5.307m12.84 3.088A5.98 5.98 0 0 1 18 12a30 30 0 0 1-.464 6.232M6 12a6 6 0 0 1 9.352-4.974M4 21a5.964 5.964 0 0 1 1.01-3.328 5.15 5.15 0 0 0 .786-1.926m8.66 2.486a13.96 13.96 0 0 1-.962 2.683M7.5 19.336C9 17.092 9 14.845 9 12a3 3 0 1 1 6 0c0 .749 0 1.521-.031 2.311M12 12c0 3 0 6-2 9"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Ubah Password</span>
                    </a>
                </li>
                @endif

                @if(Auth::user()->role === 'superadmin' || Auth::user()->role === 'karyawan' || Auth::user()->role === 'manajer')
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                        <svg class="w-5 h-5 text-gray-500 group-hover:text-gray-900 transition duration-75" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2"/>
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Keluar</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endif
            </ul>
        </div>
    </aside>

    <div class="p-4 sm:ml-64">
        <div class="mt-16">
            @yield('content')
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    @yield('scripts')
</body>

</html>