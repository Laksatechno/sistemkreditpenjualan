@extends('layout.app')

@section('title', 'Kartu Piutang')

@section('content')

<div class="mb-8">
    <span class="text-xl font-medium text-gray-900">Laporan Piutang</span>
</div>


{{-- Interaksi Pengguna --}}
<div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 mt-8">
    <div class="flex gap-2">
        {{-- Search --}}
        <div class="">
            <form action="{{ route('laporan.piutang') }}" method="GET">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="table-search" name="search" value="{{ request('search') }}" class="block py-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-96 focus:ring-gray-500 focus:border-gray-500" placeholder="Cari data piutang berdasarkan nama pelanggan">
                </div>
            </form>
        </div>

        {{-- Filter --}}
        <div class="">
            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-gray-500 bg-white border border-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                <svg class="w-5 h-5 text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                </svg>

                <span class="ml-3">Filter</span>

                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            {{-- Filter dropdown --}}
            <div id="dropdown" class="z-10 hidden bg-white border divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 focus:ring-gray-500 focus:border-gray-500">
                <form action="{{ route('laporan.piutang') }}" method="GET">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="a-z" type="radio" value="az" name="filter-piutang" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="a-z" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">A-Z</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="z-a" type="radio" value="za" name="filter-piutang" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="z-a" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Z-A</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="terbaru" type="radio" value="terbaru" name="filter-piutang" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="terbaru" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Terbaru</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="terlama" type="radio" value="terlama" name="filter-piutang" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="terlama" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Terlama</label>
                            </div>
                        </li>
                    </ul>

                    <div class="p-2">
                        <button type="submit" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 w-full rounded-lg text-gray-900 font-medium text-sm">Filter</button>
                    </div>
                </form>
            </div>
        </div>      
    </div>

    <div class="flex justify-end gap-2">
        {{-- Tombol Refresh --}}
        <a href="{{ route('laporan.piutang') }}" type="submit" class="text-white bottom-2.5 bg-white hover:bg-gray-50 border border-gray-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
            </svg>
        </a>

        {{-- Tombol Print --}}
        <a href="{{ route('laporan.cetakLaporanPiutang', ['pelanggan' => request('pelanggan')]) }}" class="text-white bottom-2.5 bg-white hover:bg-green-50 border border-green-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
            </svg>
        </a>
    </div>
</div>  

<hr class="mb-8">

<div class="mb-8">
    <div class="mb-2">
        <div class="flex">
            <div class="basis-64">
                <div class="flex justify-between">
                    <div class="font-medium">Total Kredit</div>
                    <div>:</div>
                </div>
            </div>
            <div class="basis-96 ml-4">
                <div class="font-medium">Rp{{ number_format($totalKredit, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="mb-2">
        <div class="flex">
            <div class="basis-64">
                <div class="flex justify-between">
                    <div class="font-medium">Total Angsuran Dibayarkan</div>
                    <div>:</div>
                </div>
            </div>
            <div class="basis-96 ml-4">
                <div class="font-medium">Rp{{ number_format($totalAngsuran, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div>
        <div class="flex">
            <div class="basis-64">
                <div class="flex justify-between">
                    <div class="font-medium">Total Angsuran Terutang</div>
                    <div>:</div>
                </div>
            </div>
            <div class="basis-96 ml-4">
                <div class="font-medium">Rp{{ number_format($totalAngsuranTerutang, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Display Data --}}
<div class="relative border border-gray-200 rounded-lg overflow-x-auto mt-2">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        
        <thead class="text-xs border-b text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="p-4">
                    No
                </th>
                <th scope="col" class="px-4 py-3">
                    Tanggal Pembayaran
                </th>
                <th scope="col" class="px-4 py-3">
                    Nama Pelanggan
                </th>
                <th scope="col" class="px-4 py-3">
                    ID Penjualan
                </th>
                <th scope="col" class="px-4 py-3">
                    Nominal Kredit
                </th>
                <th scope="col" class="px-4 py-3">
                    Nominal Angsuran Bulanan
                </th>
                <th scope="col" class="px-4 py-3">
                    Bunga
                </th>
                <th scope="col" class="px-4 py-3">
                    Angsuran Ke
                </th>
            </tr>
        </thead>      

        <tbody>
            @if ($piutang->isEmpty())
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td colspan="8" class="px-4 py-4 text-center font-medium text-gray-500 dark:text-white">
                    <i>Data piutang tidak ditemukan</i>
                </td>
            </tr>
            @else

            @foreach ($piutang as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="w-4 p-4 text-center">
                    {{ $loop->iteration }}
                </td>
                <td class="px-4 py-4">
                   {{
                        \Carbon\Carbon::parse($item->tanggal_pembayaran)
                            ->translatedFormat('d F Y')
                    }}
                </td>
                <td scope="row" class="px-4 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $item->penjualanKredit->pelanggan->nama_pelanggan }}
                </td>
                <td class="px-4 py-4">
                    {{ sprintf('%06d', $item->penjualan_kredit_id) }}
                </td>
                <td class="px-4 py-4">
                    {{ 'Rp' . number_format($item->penjualanKredit->total_angsur_bulanan * $item->penjualanKredit->jangka_pembayaran, 0, ',', '.') }}
                </td>
                <td class="px-4 py-4">
                    {{ 'Rp' . number_format($item->jumlah_angsur, 0, ',', '.') }}
                </td>
                </td>
                <td class="px-4 py-4">
                    2%
                </td>
                <td class="px-4 py-4">
                   {{ $item->no_angsur }} dari {{ $item->penjualanKredit->jangka_pembayaran }}
                </td>
            </tr>

            @endforeach
            @endif
        </tbody>
    </table>
</div>

@endsection