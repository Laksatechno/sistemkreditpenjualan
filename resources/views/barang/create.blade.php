@extends('layout.app')

@section('title', 'Tambah Barang')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Tambah Barang</span>
</div>

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('barang.store') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-8 md:grid-cols-2">
            <div>
                <label for="nama" class="block mb-2 text-base font-medium text-gray-900">Nama</label>
                <input type="text" id="nama" name="nama_barang" value="{{ old('nama_barang') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan nama barang" />
                @error('nama_barang')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="merk" class="block mb-2 text-base font-medium text-gray-900">Merk</label>
                <select id="merk" name="merk" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled selected>Pilih merk</option>
                    <option value="Daikin" {{ old('merk') == 'Daikin' ? 'selected' : '' }}>Daikin</option>
                    <option value="LG" {{ old('merk') == 'LG' ? 'selected' : '' }}>LG</option>
                    <option value="Panasonic" {{ old('merk') == 'Panasonic' ? 'selected' : '' }}>Panasonic</option>
                    <option value="Samsung" {{ old('merk') == 'Samsung' ? 'selected' : '' }}>Samsung</option>
                    <option value="Sharp" {{ old('merk') == 'Sharp' ? 'selected' : '' }}>Sharp</option>            
                </select>
                @error('merk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="jenis" class="block mb-2 text-base font-medium text-gray-900">Jenis</label>
                <select id="jenis" name="jenis_id" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled selected>Pilih jenis</option>
                    @foreach($jenisBarang as $jenis)
                        <option value="{{ $jenis->id_jenis }}" {{ old('jenis_id') == $jenis->id_jenis ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                    @endforeach
                </select>
                @error('jenis_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="harga" class="block mb-2 text-base font-medium text-gray-900">Harga</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan harga" />
                @error('harga')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="stok" class="block mb-2 text-base font-medium text-gray-900">Stok</label>
                <input type="number" id="stok" name="stok" value="{{ old('stok') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan stok" />
                @error('stok')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="satuan" class="block mb-2 text-base font-medium text-gray-900">Satuan</label>
                <select id="satuan" name="satuan" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled selected>Pilih satuan</option>
                    <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>unit</option>
                </select>
                @error('satuan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tambah</button>
            <a href="{{ route('barang') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

@endsection
