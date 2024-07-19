@extends('layout.app')

@section('title', 'Faktur Penjualan')

@section('content')

<div class="relative bg-white rounded-lg border pb-4">
    <div class="p-12">
        <div class="grid grid-cols-2 mb-4">
            <div>
                <h3 class="text-xl font-medium text-start mb-2">Toko Rahayu</h3>
                <p>Jl. Teknologi No. 12, Komplek Niaga, Kecamatan Elektronika, Kota Megah, 12345</p>
                <p>0812-3456-7890</p>
            </div>

            <div>
                <h3 class="text-xl font-medium text-end">Faktur Penjualan</h3>
            </div>
        </div>

        <hr class="border-1 border-gray-900">

        <div class="grid grid-cols-2 mt-4 font-medium">
            <div class="grid justify-items-start">
                <div class="flex items-center">
                    <table>
                        <tr>
                            <td>Pelanggan</td>
                            <td class="px-2">:</td>
                            <td>{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                        </tr>
                        <tr>
                            <td>Telepon</td>
                            <td class="px-2">:</td>
                            <td>{{ $penjualan->pelanggan->telepon }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td class="px-2">:</td>
                            <td>{{ $penjualan->pelanggan->alamat }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="grid justify-items-end">
                <div class="border border-gray-900 flex items-center px-2 rounded">
                    <table>
                        <tr>
                            <td>Tanggal</td>
                            <td class="px-2">:</td>
                            <td>
                                {{
                                    \Carbon\Carbon::parse($penjualan->tanggal_penjualan)
                                        ->translatedFormat('d F Y')
                                }}
                            </td>
                        </tr>
                        <tr>
                            <td>No. Penjualan</td>
                            <td class="px-2">:</td>
                            <td>{{ sprintf('%06d', $penjualan->id_penjualan_kredit) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-12">
            <p class="border-b border-gray-900 pb-2">
                Jatuh Tempo Awal :
                <span class="font-medium">
                    {{
                        \Carbon\Carbon::parse($penjualan->tanggal_penjualan)
                        ->addMonthsNoOverflow(1)
                        ->day(25)
                        ->translatedFormat('d F Y')
                    }}
                </span>
            </p>
        </div>

        <div class="relative overflow-x-auto mt-4 penjualan">
            <table class="w-full text-sm text-center">
                <thead class="text-xs uppercase">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Nama Barang
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Merk
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Kuantitas
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Harga Satuan
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Sub Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white ">
                        <td scope="row" class="px-6 py-4">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ $detail->barang->nama_barang }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ $detail->barang->merk }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ $detail->kuantitas }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ 'Rp' . number_format($detail->barang->harga, 0, ',', '.')  }}<br>
                            @endforeach
                        </td>
                        <td class="px-6 py-4">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ 'Rp' . number_format($detail->barang->harga * $detail->kuantitas, 0, ',', '.')  }}<br>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <div class="flex justify-end">
                <table class="text-end">
                    <tr>
                        <td>Sub Total</td>
                        <td class="pl-2 pr-8">:</td>
                        <td>{{ 'Rp' . number_format($penjualan->total_harga, 0, ',', '.')  }}</td>
                    </tr>
                    <tr>
                        <td>Uang Muka</td>
                        <td class="pl-2 pr-8">:</td>
                        <td>{{ 'Rp' . number_format($penjualan->down_payment, 0, ',', '.')  }}</td>
                    </tr>
                    <tr>
                        <td>Sisa Pembayaran</td>
                        <td class="pl-2 pr-8">:</td>
                        <td>{{ 'Rp' . number_format($penjualan->sisa_angsur, 0, ',', '.')  }}</td>
                    </tr>
                    <tr>
                        <td>Jangka Waktu Pembayaran</td>
                        <td class="pl-2 pr-8">:</td>
                        <td>{{ $penjualan->jangka_pembayaran }} bulan</td>
                    </tr>
                    <tr>
                        <td>Bunga</td>
                        <td class="pl-2 pr-8">:</td>
                        <td>{{ 'Rp' . number_format($penjualan->bunga, 0, ',', '.')  }} / bulan</td>
                    </tr>
                    <tr class="font-medium">
                        <td>Total Angsuran Pokok Bulanan</td>
                        <td class="pl-2 pr-8">:</td>
                        <td>{{ 'Rp' . number_format($penjualan->total_angsur_bulanan, 0, ',', '.')  }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-12">
            <div class="grid grid-cols-2 justify-items-center">
                <div class="text-center">
                    <p class="mb-16">Pembeli</p>
                    <p class="border-b border-gray-900 pb-1 font-medium">{{ $penjualan->pelanggan->nama_pelanggan }}</p>
                </div>
                <div class="text-center">
                    <p class="mb-16">Admin Kasir</p>
                    <p class="border-b border-gray-900 pb-1 font-medium">{{ Auth::user()->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tombol --}}
<div class="flex items-center justify-end mt-4 rounded-b dark:border-gray-600">                                                        
    <a href="{{ route('penjualan.faktur', $penjualan->id_penjualan_kredit) }}" class="py-2.5 px-5 text-sm font-medium text-white focus:outline-none bg-blue-700 rounded-lg hover:bg-blue-800 mr-2">
        Cetak Faktur
    </a>

    <a href="{{ route('penjualan') }}" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-gray-100 rounded-lg border border-gray-200 hover:bg-gray-200 hover:text-gray-700">
        Kembali
    </a>
</div>


@endsection