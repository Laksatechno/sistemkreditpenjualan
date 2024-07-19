@extends('layout.app')

@section('title', 'Angsuran')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Daftar Angsuran</span>
</div>

{{-- Interaksi Pengguna --}}
<div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4 mt-8">
    {{-- Tombol Tambah Data Angsuran --}}
    <div class="flex items-center">
        <a href="{{ route('angsuran.create') }}" type="button" class="bg-blue-700 px-5 py-2.5  rounded-md text-white text-sm font-medium hover:bg-blue-800">
            Tambah Data Angsuran
        </a>
    </div>

    <div class="flex">
        {{-- Filter --}}
        <div>
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
                <form action="{{ route('angsuran') }}" method="GET">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="a-z" type="radio" value="az" name="filter-angsuran" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="a-z" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">A-Z</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="z-a" type="radio" value="za" name="filter-angsuran" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="z-a" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Z-A</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="terbaru" type="radio" value="terbaru" name="filter-date" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
                                <label for="terbaru" class="w-full ms-3 text-sm font-medium text-gray-900 rounded dark:text-gray-300">Terbaru</label>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center justify-start px-4 py-2 hover:bg-gray-100">
                                <input id="terlama" type="radio" value="terlama" name="filter-date" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300">
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

        {{-- Search --}}
        <div class="ml-4">
            <form action="{{ 'angsuran' }}" method="GET">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 rtl:inset-r-0 rtl:right-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <input type="text" id="table-search" name="search" value="{{ request('search') }}" class="block py-2.5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 focus:ring-gray-500 focus:border-gray-500" placeholder="Cari data angsuran">
                </div>
            </form>
        </div>

        <div class="ml-4">
            <a href="{{ route('angsuran.cetakDataAngsuran', ['filter-angsuran' => request('filter-angsuran'), 'filter-date' => request('filter-date'), 'search' => request('search')]) }}" class="inline-flex text-white bg-white hover:bg-green-50 border border-green-500 font-medium rounded-lg text-sm px-4 py-2.5">
                <svg class="w-5 h-5 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
                </svg>
            </a>
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
                    Barang
                </th>
                <th scope="col" class="px-4 py-3">
                    Nominal Angsuran
                </th>
                <th scope="col" class="px-4 py-3">
                    Angsuran ke
                </th>
                <th scope="col" class="px-4 py-3 text-center">
                    Aksi
                </th>
            </tr>
        </thead>      

        <tbody>
            @forelse ($angsuran as $item)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4 text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-4 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        {{
                            \Carbon\Carbon::parse($item->tanggal_pembayaran)
                                ->translatedFormat('d F Y')
                        }}
                    </td>
                    <td class="px-4 py-4">
                        {{ $item->penjualanKredit->pelanggan->nama_pelanggan }}
                    </td>
                    <td class="px-4 py-4">
                        {{ $item->penjualanKredit->detailPenjualanKredit->first()->barang->nama_barang }}
                    </td>
                    <td class="px-4 py-4">
                        {{ 'Rp' . number_format($item->jumlah_angsur, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-4">
                        {{ $item->no_angsur }} dari {{ $item->penjualanKredit->jangka_pembayaran }}
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-2">
                            {{-- Tombol trigger edit --}}
                            <a href="{{ route('angsuran.edit', $item->id_angsuran) }}">
                                <svg class="w-5 h-5 text-blue-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                </svg>
                            </a>
                            
                            {{-- Tombol trigger delete --}}
                            <a href="#" data-modal-target="delete-modal-{{ $item->id_angsuran }}" data-modal-toggle="delete-modal-{{ $item->id_angsuran }}">
                                <svg class="w-5 h-5 text-red-500 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>

                {{-- Modal Delete Data --}}
                <div id="delete-modal-{{ $item->id_angsuran }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700 py-8">
                            {{-- Modal Body --}}
                            <div class="p-4 md:p-5 space-y-4">
                                <?php
                                    $id_angsuran = 2;
                                    $formatted_id = sprintf('%06d', $id_angsuran);
                                ?>

                                <p class="text-xl font-medium leading-relaxed text-center text-gray-500 dark:text-gray-400">
                                    Hapus angsuran <span class="text-gray-900"> {{ sprintf('%06d', $item->id_angsuran) }} </span>?
                                </p>
                                <p class="text-sm leading-relaxed text-center text-gray-500 dark:text-gray-400">
                                    Dengan menekan tombol <b>Hapus</b>, maka data angsuran akan terhapus secara permanen.
                                </p>
                            </div>

                            <div class="flex items-center justify-center p-4 md:p-5 rounded-b dark:border-gray-600">
                                <form action="{{ route('angsuran.destroy', $item->id_angsuran) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button data-modal-hide="delete-modal" type="submit" class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Hapus</button>
                                </form>
                                
                                <a href="" data-modal-hide="delete-modal-{{ $item->id_angsuran }}" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-700">
                                    Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td colspan="7" class="px-4 py-4 text-center font-medium text-gray-500 dark:text-white">
                        <i>Data angsuran tidak ditemukan</i>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
