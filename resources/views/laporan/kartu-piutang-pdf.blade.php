<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>
        Kartu Piutang
        @if($penjualanKredit && $penjualanKredit->pelanggan)
            - {{ $penjualanKredit->pelanggan->id_pelanggan }} - {{ $penjualanKredit->pelanggan->nama_pelanggan }}
        @endif
    </title>
    
    <style>
    
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

        .text-end {
            text-align: end;
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
    </style>
</head>

<body>
    <div class="leading-6">
        <div class="text-center uppercase mb-16 font-medium">
            <b>
                KARTU PIUTANG <br>
                TOKO RAHAYU ELEKTRONIK
            </b>
        </div>

        <div class="mb-8">
            <table>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;  ">Nama Pelanggan</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualanKredit->pelanggan->nama_pelanggan }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;  ">Telepon</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualanKredit->pelanggan->telepon }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;  ">Alamat</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualanKredit->pelanggan->alamat }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;  ">Tanggal Peminjaman</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ \Carbon\Carbon::parse($penjualanKredit->tanggal_penjualan)->translatedFormat('d F Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="mb-8">
            <table>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Nominal Pembelian</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualanKredit->total_harga, 0, ',', '.') }}</td>

                    <td style="padding-left: 5rem; padding-right: 2rem; border: 0px !important;"></td>
                    
                    <td style="border: 0px !important;">Jangka Waktu Pinjaman</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ $penjualanKredit->jangka_pembayaran }} bulan</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Nominal Uang Muka</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualanKredit->down_payment, 0, ',', '.') }}</td>

                    {{-- <td style="border: 0px !important; color: #FFFFFF"">Jangka Waktu Peminja</td> --}}
                    <td style="padding-left: 5rem; padding-right: 2rem; border: 0px !important;"></td>

                    <td style="border: 0px !important;">Angsuran Pokok</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualanKredit->total_angsur_bulanan, 0, ',', '.') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Nominal Kredit</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualanKredit->total_angsur_bulanan * $penjualanKredit->jangka_pembayaran, 0, ',', '.') }}</td>

                    {{-- <td style="border: 0px !important; color: #FFFFFF"">Jangka Waktu Pem</td> --}}
                    <td style="padding-left: 5rem; padding-right: 2rem; border: 0px !important;"></td>

                    <td style="border: 0px !important;">Sisa Angsuran</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($sisaAngsuran, 0, ',', '.') }}</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;">Nominal Bunga</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ 'Rp' . number_format($penjualanKredit->bunga, 0, ',', '.') }}</td>

                    {{-- <td style="border: 0px !important; color: #FFFFFF"">Jangka Waktu</td> --}}
                    <td style="padding-left: 5rem; padding-right: 2rem; border: 0px !important;"></td>

                    <td style="border: 0px !important;">Status Pinjaman</td>
                    <td style="border: 0px !important;">:</td>
                    <td style="border: 0px !important;">{{ ucfirst($penjualanKredit->status) }}</td>
                </tr>
            </table>
        </div>

        <div>
            <table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-center px-4 py-3">No</th>
                        <th class="text-center px-4 py-3">Jatuh Tempo</th>
                        <th class="text-center px-4 py-3">Angsuran Ke</th>
                        <th class="text-center px-4 py-3">Nominal Angsuran</th>
                        <th class="text-center px-4 py-3">Bunga</th>
                        <th class="text-center px-4 py-3">Status Pembayaran</th>
                        <th class="text-center px-4 py-3">Tanggal Pembayaran</th>
                        <th class="text-center px-4 py-3">Nominal Pembayaran</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($angsuran as $item)
                        <tr>
                            <td class="text-center px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->jatuh_tempo)->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-3 text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ 'Rp' . number_format($penjualanKredit->total_angsur_bulanan, 0, ',', '.') }}</td>
                            <td class="text-center">{{ 'Rp' . number_format($penjualanKredit->bunga, 0, ',', '.') }}</td>
                            <td class="text-center">{{ ucfirst($item->status_pembayaran) }}</td>
                            <td class="text-center">{{ $item->tanggal_pembayaran ? \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') : '-' }}</td>
                            <td class="text-center">{{ 'Rp' . number_format($item->jumlah_angsur, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
