<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Laporan Penjualan Terlaris Periode {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s.d. {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</title>
    
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
                Laporan Penjualan Barang Terlaris <br>
                Periode {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} S.D. {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }} <br>
                TOKO RAHAYU ELEKTRONIK
            </b>
        </div>

        <div>
            <table>
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-center px-4 py-3">No</th>
                        <th class="text-center px-4 py-3">ID Barang</th>
                        <th class="text-center px-4 py-3">Nama Barang</th>
                        <th class="text-center px-4 py-3">Merk</th>
                        <th class="text-center px-4 py-3">Jenis</th>
                        <th class="text-center px-4 py-3">Jumlah Terjual</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($barangTerlaris as $item)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-center px-4 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $item->id_barang }}
                            </td>
                            <td class="px-4 py-4">
                                {{ $item->nama_barang }}
                            </td>
                            <td class="text-center px-4 py-4">
                                {{ $item->merk }}
                            </td>
                            <td class="text-center px-4 py-4">
                                {{ $item->jenis }}
                            </td>
                            <td class="text-center px-4 py-4">
                                {{ $item->total_terjual }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
