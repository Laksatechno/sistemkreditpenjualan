@extends('layout.app')

@section('title', 'Kartu Piutang')

@section('content')

<div class="mb-8">
    <span class="text-xl font-medium text-gray-900">Kartu Piutang</span>
</div>

{{-- Pencarian --}}
<div class="grid grid-cols-3 items-center mb-4">
    <div></div>

    <div>
        <form action="{{ route('kartuPiutang') }}" method="GET" class="flex items-center gap-2">
            <div class="w-60">
                <select id="penjualan" name="penjualan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled {{ !request('penjualan') ? 'selected' : '' }}>Pilih ID Penjualan</option>
                    @foreach($penjualanIds as $penjualan)
                        <option value="{{ $penjualan['id'] }}" {{ request('penjualan') == $penjualan['id'] ? 'selected' : '' }}>
                            {{ sprintf('%06d', $penjualan['id']) }} - {{ $penjualan['nama'] }}
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
        <a href="{{ route('kartuPiutang') }}" class="text-white bottom-2.5 bg-white hover:bg-gray-50 border border-gray-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-gray-700 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.651 7.65a7.131 7.131 0 0 0-12.68 3.15M18.001 4v4h-4m-7.652 8.35a7.13 7.13 0 0 0 12.68-3.15M6 20v-4h4"/>
            </svg>
        </a>
        
        {{-- Tombol Print --}}
        <a href="{{ route('kartuPiutang.cetak', ['penjualan' => request('penjualan')]) }}" class="text-white bottom-2.5 bg-white hover:bg-green-50 border border-green-500 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-5 h-5 text-green-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M8 3a2 2 0 0 0-2 2v3h12V5a2 2 0 0 0-2-2H8Zm-3 7a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h1v-4a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v4h1a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2H5Zm4 11a1 1 0 0 1-1-1v-4h8v4a1 1 0 0 1-1 1H9Z" clip-rule="evenodd"/>
            </svg>
        </a>

    </div>
</div>

@if ($penjualanKredit)
<hr class="mb-8">

<div class="p-8 border rounded-lg shadow-sm">
    <div class="mb-8 font-medium">
        <div class="mb-8">
            <table>
                <tr>
                    <td>Nama Pelanggan</td>
                    <td class="px-4">:</td>
                    <td>{{ $penjualanKredit->pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr>
                    <td>Telepon</td>
                    <td class="px-4">:</td>
                    <td>{{ $penjualanKredit->pelanggan->telepon }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td class="px-4">:</td>
                    <td>{{ $penjualanKredit->pelanggan->alamat }}</td>
                </tr>
                <tr>
                    <td>Tanggal Peminjaman</td>
                    <td class="px-4">:</td>
                    <td>{{ \Carbon\Carbon::parse($penjualanKredit->tanggal_penjualan)->translatedFormat('d F Y') }}</td>
                </tr>       
            </table>
        </div>

        <div class="flex items-start justify-between">
            <div class="">
                <table class="w-full">
                    <tr class="">
                        <td>Nominal Pembelian</td>
                        <td class="px-4">:</td>
                        <td>{{ 'Rp' . number_format($penjualanKredit->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Nominal Uang Muka</td>
                        <td class="px-4">:</td>
                        <td>{{ 'Rp' . number_format($penjualanKredit->down_payment, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Nominal Kredit</td>
                        <td class="px-4">:</td>
                        <td>{{ 'Rp' . number_format($penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Nominal Bunga</td>
                        <td class="px-4">:</td>
                        <td>{{ 'Rp' . number_format($penjualanKredit->bunga, 0, ',', '.') }} (2%)</td>
                    </tr>
                </table>
            </div>

            <div>
                <table>
                    <tr>
                        <td>Jangka Waktu Pinjaman</td>
                        <td class="px-4">:</td>
                        <td>{{ $penjualanKredit->jangka_pembayaran }} bulan</td>
                    </tr>
                    <tr>
                        <td>Angsuran Pokok</td>
                        <td class="px-4">:</td>
                        <td>{{ 'Rp' . number_format($penjualanKredit->total_angsur_bulanan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Sisa Angsuran</td>
                        <td class="px-4">:</td>
                        <td>{{ 'Rp' . number_format($sisaAngsuran, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Status Kredit</td>
                        <td class="px-4">:</td>
                        <td>{{ ucfirst($penjualanKredit->status) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="font-medium">
        <div class="relative border border-gray-200 rounded-lg overflow-x-auto mt-2">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs border-b text-gray-700 bg-gray-100 uppercase dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4 py-3 text-center">
                            No
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Jatuh Tempo
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Angsuran ke
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Nominal
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Bunga
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Status
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Tanggal Pembayaran
                        </th>
                        <th scope="col" class="px-4 py-3 text-center">
                            Nominal Pembayaran
                        </th>
                    </tr>
                </thead>  

                <tbody>
                    @foreach ($angsuran as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4 text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="w-4 p-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->jatuh_tempo)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ 'Rp' . number_format($penjualanKredit->total_angsur_bulanan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ 'Rp' . number_format($penjualanKredit->bunga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ ucfirst($item->status_pembayaran) }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') : '-' }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ 'Rp' . number_format($item->jumlah_angsur, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection
