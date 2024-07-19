<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Faktur Penjualan</title>
    
    {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}

    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .leading-6 {
            line-height: 1.5;
        }

        .text-center {
            text-align: center;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .mb-16 {
            margin-bottom: 4rem;
        }

        .text-xl {
            font-size: 1.25rem;
        }

        .text-end {
            text-align: end;
        }

        .text-white {
            color: #ffffff;
        }

        .mb-8 {
            margin-bottom: 2rem;
        }

        .flex {
            display: flex;
        }

        .flex-none {
            flex: none;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .w-20 {
            width: 5rem; /* 80px */
        }

        .w-4 {
            width: 1rem; /* 16px */
        }

        .w-full {
            width: 100%;
        }

        .font-medium {
            font-weight: 600;
        }

        .px-4 {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .py-3 {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 0.5rem;
            border: 1px solid #000000; /* gray-200 */
        }

        th {
            background-color: #f4f4f4;
        }

        .bg-white {
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="leading-6">
        <div class="text-center uppercase mb-8 font-medium">
            <b>
                FAKTUR PENJUALAN
            </b>
        </div>

        <div class="mb-8">
            <table>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Tanggal</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ \Carbon\Carbon::parse($penjualan->tanggal_penjualan)->translatedFormat('d F Y') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Nomor</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ sprintf('%06d', $penjualan->id_penjualan_kredit) }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Nama</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Telepon</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualan->pelanggan->telepon }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Alamat</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualan->pelanggan->alamat }}</td>
                </tr>
            </table>
        </div>

        <div class="mb-8">
            <table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-center px-4 py-3">Nama Barang</th>
                        <th class="text-center px-4 py-3">Merk</th>
                        <th class="text-center px-4 py-3">Kuantitas</th>
                        <th class="text-center px-4 py-3">Harga Satuan</th>
                        <th class="text-center px-4 py-3">Sub Total</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="">
                        <td class="text-center">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ $detail->barang->nama_barang }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ $detail->barang->merk }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-center">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ $detail->kuantitas }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-center">
                            @foreach($penjualan->detailPenjualanKredit as $detail)
                                {{ 'Rp' . number_format($detail->barang->harga, 0, ',', '.')  }}<br>
                            @endforeach
                        </td>
                        <td class="px-4 py-4 text-end">
                            {{ 'Rp' . number_format($penjualan->total_harga, 0, ',', '.')  }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-16">
            <table style="width: 360px;">
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Sub Total</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Uang Muka</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualan->down_payment, 0, ',', '.') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Sisa Pembayaran</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualan->sisa_angsur, 0, ',', '.') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Jangka Pembayaran</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualan->jangka_pembayaran }} bulan</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Bunga</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualan->bunga, 0, ',', '.') }} / bulan</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Total Kredit</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualan->total_angsur_bulanan * $penjualan->jangka_pembayaran, 0, ',', '.') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Total Angsuran Pokok Bulanan</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualan->total_angsur_bulanan, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div>
            <table  class="text-center">
                <tr>
                    <td style="padding-bottom: 4rem; border: 0px !important;">Pembeli</td>
                    <td style="padding-bottom: 4rem; border: 0px !important;">Admin Kasir</td>
                </tr>
                <tr>
                    <td style="border: 0px !important;">{{ $penjualan->pelanggan->nama_pelanggan }}</td>
                    <td style="border: 0px !important;">{{ Auth::user()->name }}</td>
                </tr>
            </table>
        </div>

    </div>
</body>
</html>
