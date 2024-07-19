@extends('layout.app')

@section('title', 'Edit Angsuran')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Edit Data Angsuran</span>
</div>

@if ($message = Session::get('error'))
    <div class="flex items-center justify-center my-8">
        <p class="text-red-700 bg-red-100 py-2.5 px-5 rounded-lg">
            <span class="font-medium">{{ $message }}</span>. Silahkan coba lagi nanti.
        </p>
    </div>
@endif

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('angsuran.update', $angsuran->id_angsuran) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="id_penjualan" class="block mb-2 text-base font-medium text-gray-900">ID Penjualan Kredit</label>
                <select id="id_penjualan" name="id_penjualan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    @foreach ($penjualanKredits as $penjualanKredit)
                    <option value="{{ $penjualanKredit->id_penjualan_kredit }}" {{ $penjualanKredit->id_penjualan_kredit == $angsuran->penjualan_kredit_id ? 'selected' : '' }} data-jangka="{{ $penjualanKredit->jangka_pembayaran }}" data-pelanggan="{{ $penjualanKredit->pelanggan->nama_pelanggan }}">
                        {{ $penjualanKredit->id_penjualan_kredit }}
                    </option>
                    @endforeach
                </select>
                @error('id_penjualan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tanggal" class="block mb-2 text-base font-medium text-gray-900">Tanggal Pembayaran</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input datepicker type="text" id="tanggal" name="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($angsuran->tanggal_pembayaran)->format('m/d/Y')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5" placeholder="Pilih tanggal pembayaran angsuran">
                </div>
                @error('tanggal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="pelanggan" class="block mb-2 text-base font-medium text-gray-900">Nama Pelanggan</label>
                <input type="text" id="pelanggan" name="pelanggan" value="{{ old('pelanggan', $angsuran->penjualanKredit->pelanggan->nama_pelanggan) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" readonly />
                @error('pelanggan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="angsuran_ke" class="block mb-2 text-base font-medium text-gray-900">Angsuran ke</label>
                <select id="angsuran_ke" name="angsuran_ke" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    @for ($i = 1; $i <= $angsuran->penjualanKredit->jangka_pembayaran; $i++)
                        <option value="{{ $i }}" {{ $i == $angsuran->no_angsur ? 'selected' : '' }}>Angsuran ke-{{ $i }}</option>
                    @endfor
                </select>
                @error('angsuran_ke')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nominal" class="block mb-2 text-base font-medium text-gray-900">Nominal Angsuran</label>
                <input type="number" id="nominal" name="nominal" value="{{ old('nominal', $angsuran->jumlah_angsur) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan nominal pembayaran angsuran" />
                @error('nominal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan Perubahan</button>
            <a href="{{ route('angsuran') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

@endsection

