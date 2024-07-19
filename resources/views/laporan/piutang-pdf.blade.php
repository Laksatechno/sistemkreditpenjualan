<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Laporan Piutang</title>
    
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

        .mb-4 {
            margin-bottom: 1rem;
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
        <div class="text-center uppercase font-medium">
            <b>
                Laporan Piutang <br>
                TOKO RAHAYU ELEKTRONIK
            </b>
        </div>

        <div class="mb-4">
            <table>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important; color: white;">Total angsuran diterima</td>
                    <td style="border: 0px !important; color: white;">:</td>
                    <td style="border: 0px !important; color: white;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem quod minima illum magni cum cupiditate repellendus iste nulla voluptates nobis laboriosam dolorum eligendi fuga veritatis officiis, tenetur, ipsum ex. Dolore.</td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;"><b>Total kredit pelanggan</b></td>
                    <td style="border: 0px !important;"><b>:</b></td>
                    <td style="border: 0px !important;"><b>Rp{{ number_format($totalKredit, 0, ',', '.') }}</b></td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;"><b>Total angsuran dibayarkan</b></td>
                    <td style="border: 0px !important;"><b>:</b></td>
                    <td style="border: 0px !important;"><b>Rp{{ number_format($totalAngsuran, 0, ',', '.') }}</b></td>
                </tr>
                <tr style="vertical-align: top !important">
                    <td style="border: 0px !important;"><b>Total angsuran terutang</b></td>
                    <td style="border: 0px !important;"><b>:</b></td>
                    <td style="border: 0px !important;"><b>Rp{{ number_format($totalAngsuranTerutang, 0, ',', '.') }}</b></td>
                </tr>
            </table>
        </div>

        <div>
            <table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-center px-4 py-3">No</th>
                        <th class="text-center px-4 py-3">Tanggal Pembayaran</th>
                        <th class="text-center px-4 py-3">Nama Pelanggan</th>
                        <th class="text-center px-4 py-3">ID Penjualan</th>
                        <th class="text-center px-4 py-3">Nominal Kredit</th>
                        <th class="text-center px-4 py-3">Nominal Angsuran Bulanan</th>
                        <th class="text-center px-4 py-3">Bunga</th>
                        <th class="text-center px-4 py-3">Angsuran Ke</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($piutang as $item)
                        <tr>
                            <td class="text-center px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($item->tanggal_pembayaran)->translatedFormat('d F Y') }}</td>
                            <td class="px-4 py-3">{{ $item->penjualanKredit->pelanggan->nama_pelanggan }}</td>
                            <td class="px-4 py-3">{{ sprintf('%06d', $item->penjualan_kredit_id) }}</td>
                            <td class="px-4 py-3">{{ 'Rp' . number_format($item->penjualanKredit->total_angsur_bulanan * $item->penjualanKredit->jangka_pembayaran, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">{{ 'Rp' . number_format($item->jumlah_angsur, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">2%</td>
                            <td class="text-center">{{ $item->no_angsur }} dari {{ $item->penjualanKredit->jangka_pembayaran }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
