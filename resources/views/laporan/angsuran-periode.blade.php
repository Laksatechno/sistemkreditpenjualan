@extends('layout.app')

@section('title', 'Laporan Angsuran Per Periode')

@section('content')

<div class="mb-8">
    <span class="text-xl font-medium text-gray-900">Laporan Angsuran per Periode</span>
</div>

{{-- Pencarian --}}
<div class="grid grid-cols-3 items-center mb-4">
    <div></div>

    {{-- Datepciker Periode --}}
    <div> 
        <form action="{{ route('laporan.angsuranPeriode') }}" class="max-w-md mx-auto bg-gray-50 border rounded-lg" method="GET">   
            <div date-rangepicker class="flex items-center gap-4 m-2">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input name="start" type="text" value="{{ request('start') }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Tanggal awal">
                </div>
                <span class="text-gray-500">-</span>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input name="end" type="text" value="{{ request('end') }}" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5" placeholder="Tanggal akhir">
                </div>

                <button type="submit" class="text-white p-2.5 bg-blue-700 hover:bg-blue-800 border font-medium rounded-md text-sm px-4">
                    Tampilkan
                </button>
            </div>
        </form>
        
        <div class="flex items-center justify-center mt-2">
            @error('start')
            <div class="text-center">
                <span class="text-red-500 text-sm text-center">{{ $message }}</span>
                <span class="text-red-500 text-sm text-center">dan</span>
            </div>
            @enderror

            @error('end')
            <div class="text-center">
                <span class="text-red-500 text-sm text-center mr-1"></span>
                <span class="text-red-500 text-sm text-center"> {{ $message }}</span>
            </div>
            @enderror
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end gap-2">
        {{-- Tombol Refresh --}}
        <a href="{{ route('laporan.angsuranPeriode') }}" type="submit" class="text-white bottom-2.5 bg-white hover:bg-gray-50 border border-gray-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
            </svg>
        </a>

        {{-- Tombol Print --}}
        <a href="{{ route('laporan.cetakAngsuranPeriode', ['start' => request('start'), 'end' => request('end')]) }}" class="text-white bottom-2.5 bg-white hover:bg-green-50 border border-green-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
            </svg>
        </a>
    </div>
</div>

{{-- Tampilkan data angsuran per periode --}}
@if ($angsuran->isEmpty())
    @if (request('start') && request('end'))
        <hr class="mb-8">
        <div class="text-center">
            <i class="text-gray-900 font-medium">Data angsuran tidak ditemukan pada periode ini</i>
        </div>
    @endif
@else

<hr class="mb-8">

<div class="relative border border-gray-200 rounded-lg overflow-x-auto">

        {{-- Tabel Display Data --}}
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            {{-- Table Head --}}
            <thead class="text-xs border-b text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        No
                    </th>
                    <th scope="col" class="px-4 py-3">
                        Tanggal Pembayaran
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
                </tr>
            </thead>      

            {{-- Table Body --}}
            <tbody>
                @foreach ($angsuran as $item)
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
                            {{ $item->penjualanKredit->detailPenjualanKredit->first()->barang->nama_barang }}
                        </td>
                        <td class="px-4 py-4">
                            {{ 'Rp' . number_format($item->jumlah_angsur, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4">
                            {{ $item->no_angsur }} dari {{ $item->penjualanKredit->jangka_pembayaran }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif

@endsection
