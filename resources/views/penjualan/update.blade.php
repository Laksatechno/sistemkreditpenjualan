@extends('layout.app')

@section('title', 'Update Penjualan')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Edit Penjualan</span>
</div>

@if ($message = Session::get('error'))
    <div class="flex items-center justify-center my-8">
        <p class="text-red-700 bg-red-100 py-2.5 px-5 rounded-lg">
           <span class="font-medium">{{ $message }}</span>. Silahkan coba lagi nanti.
        </p>
    </div>
@endif

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('penjualan.update', $penjualan->id_penjualan_kredit) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-4 md:grid-cols-2">
            <div> 
                <label for="tanggal_penjualan" class="block mb-2 text-base font-medium text-gray-900">Tanggal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input datepicker type="text" id="tanggal_penjualan" name="tanggal_penjualan" value="{{ old('tanggal_penjualan', $penjualan->tanggal_penjualan) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5" placeholder="Pilih tanggal pembelian">
                </div>              
                @error('tanggal_penjualan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="pelanggan" class="block mb-2 text-base font-medium text-gray-900">Nama Pelanggan</label>
                <select id="pelanggan" name="pelanggan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled>Pilih nama pelanggan</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}" {{ $penjualan->pelanggan_id == $pelanggan->id_pelanggan ? 'selected' : '' }}>{{ $pelanggan->nama_pelanggan }}</option>
                    @endforeach
                </select>
                @error('pelanggan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="barang" class="block mb-2 text-base font-medium text-gray-900">Barang</label>
            <select id="barang" name="barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                <option value="" disabled>Pilih barang</option>
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->id_barang }}" data-harga="{{ $barang->harga }}" {{ $penjualan->detailPenjualanKredit->first()->barang_id == $barang->id_barang ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                @endforeach
            </select>
            @error('barang')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div>
                <label for="kuantitas" class="block mb-2 text-base font-medium text-gray-900">Jumlah</label>
                <input type="number" id="kuantitas" name="kuantitas" value="{{ old('kuantitas', $penjualan->detailPenjualanKredit->first()->kuantitas) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan kuantitas" />
                @error('kuantitas')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="total_harga" class="block mb-2 text-base font-medium text-gray-900">Total Harga</label>
                <input type="hidden" id="total_harga_hidden" name="total_harga" value="" disabled />
                <input type="text" id="total_harga" value="{{ old('total_harga', number_format($penjualan->total_harga, 2, ',', '.')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Total harga akan muncul otomatis" disabled />
                @error('total_harga')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="down_payment" class="block mb-2 text-base font-medium text-gray-900">Uang Muka</label>
                <input type="number" id="down_payment" name="down_payment" value="{{ old('down_payment', $penjualan->down_payment) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan jumlah uang muka" />
                @error('down_payment')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="jangka_pembayaran" class="block mb-2 text-base font-medium text-gray-900">Jangka Waktu Pembayaran (bulan)</label>
                <input type="number" id="jangka_pembayaran" name="jangka_pembayaran" value="{{ old('jangka_pembayaran', $penjualan->jangka_pembayaran) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan jangka waktu pembayaran" />
                @error('jangka_pembayaran')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
            <a href="{{ route('penjualan') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

<script>
    // Dapatkan elemen input kuantitas dan total_harga
    const inputKuantitas = document.getElementById('kuantitas');
    const inputTotalHarga = document.getElementById('total_harga');

    // Tambahkan event listener untuk perubahan nilai pada input kuantitas
    inputKuantitas.addEventListener('input', function() {
        // Dapatkan nilai kuantitas dan harga satuan barang
        const kuantitas = inputKuantitas.value;
        const selectedOption = document.getElementById('barang').querySelector('option:checked');
        const hargaSatuan = selectedOption.getAttribute('data-harga');

        // Hitung total harga
        const totalHarga = kuantitas * hargaSatuan;

        // Format total harga menjadi format mata uang "Rp1.400.000"
        const formattedTotalHarga = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalHarga);

        // Set nilai total_harga pada input
        inputTotalHarga.value = formattedTotalHarga;
    });
</script>

@endsection
