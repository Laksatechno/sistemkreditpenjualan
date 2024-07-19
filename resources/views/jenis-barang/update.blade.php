@extends('layout.app')

@section('title', 'Update Barang')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Edit Jenis Barang</span>
</div>

<div class="border rounded-lg p-4 mt-4 w-1/2">
    <form action="{{ route('jenis-barang.update', $jenisBarang->id_jenis) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="nama" class="block mb-2 text-base font-medium text-gray-900">Nama</label>
            <input type="text" id="nama" name="nama_jenis" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" value="{{ old('nama_jenis', $jenisBarang->nama_jenis) }}" />
            @error('nama_jenis')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
            <a href="{{ route('barang') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

@endsection
