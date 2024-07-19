@extends('layout.app')

@section('title', 'Laporan Angsuran Per Pelanggan')

@section('content')

<div class="mb-8">
    <span class="text-xl font-medium text-gray-900">Laporan Angsuran per Pelanggan</span>
</div>

{{-- Pencarian --}}
<div class="grid grid-cols-3 gap-6 items-center mb-4">
    <div></div>

    {{-- Formulir Pencarian --}}
    <div>
        <form action="{{ route('laporan.angsuranPelanggan') }}" class="flex items-center gap-2" method="GET">   
            <div class="w-60">
                <select id="pelanggan" name="pelanggan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled {{ !request('pelanggan') ? 'selected' : '' }}>Pilih Nama Pelanggan</option>
                    @foreach($pelangganList as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}" {{ request('pelanggan') == $pelanggan->id_pelanggan ? 'selected' : '' }}>
                            {{ $pelanggan->nama_pelanggan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5">
                    Cari
                </button>
            </div>
        </form>
    </div>

    {{-- Tombol Aksi --}}
    <div class="flex justify-end gap-2">
        {{-- Tombol Refresh --}}
        <a href="{{ route('laporan.angsuranPelanggan') }}" type="submit" class="text-white bottom-2.5 bg-white hover:bg-gray-50 border border-gray-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
            </svg>
        </a>

        {{-- Tombol Print --}}
        <a href="{{ route('laporan.cetakAngsuranPelanggan', ['pelanggan' => request('pelanggan')]) }}" class="text-white bottom-2.5 bg-white hover:bg-green-50 border border-green-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
            </svg>
        </a>
    </div>
</div>

<hr class="mb-8">

{{-- Tampilkan data angsuran per pelanggan --}}
@if ($angsuran->isEmpty())
    @if (request('pelanggan'))
        <div class="text-center">
            <i class="text-gray-900 font-medium">Data pelanggan tidak ditemukan</i>
        </div>
    @endif
@else

<div class="p-8 border rounded-lg shadow-sm">
    {{-- Identitas Pelanggan --}}
    <div class="mb-8 font-medium">
        <table>
            <tr>
                <td>Nama</td>
                <td class="px-4">:</td>
                <td>{{ $angsuran->first()->penjualanKredit->pelanggan->nama_pelanggan}}</td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td class="px-4">:</td>
                <td>{{ $angsuran->first()->penjualanKredit->pelanggan->telepon}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td class="px-4">:</td>
                <td>{{ $angsuran->first()->penjualanKredit->pelanggan->alamat}}</td>
            </tr>
        </table>
    </div>

    <div class="relative border border-gray-200 rounded-lg overflow-x-auto">

        {{-- Tabel Displa Data --}}
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

</div>
@endif

@endsection
