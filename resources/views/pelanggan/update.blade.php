@extends('layout.app')

@section('title', 'Update Pelanggan')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Edit Pelanggan</span>
</div>

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="nama" class="block mb-2 text-base font-medium text-gray-900">Nama</label>
                <input type="text" id="nama" name="nama_pelanggan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" />
                @error('nama_pelanggan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="telepon" class="block mb-2 text-base font-medium text-gray-900">Telepon</label>
                <input type="text" id="telepon" name="telepon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" value="{{ old('telepon', $pelanggan->telepon) }}" />
                @error('merk')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="alamat" class="block mb-2 text-base font-medium text-gray-900">Alamat</label>
                <input type="text" id="alamat" name="alamat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" value="{{ old('alamat', $pelanggan->alamat) }}" />
                @error('alamat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="file_identitas" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Update File Scan Identitas</label>
                <input type="file" id="file_identitas" name="file_identitas" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="kartu_identitas_help" />
                @if ($pelanggan->file_identitas)
                    <p class="text-gray-500 text-sm mt-2">File identitas saat ini: {{ $pelanggan->file_identitas }}</p>
                @else
                    <p class="text-gray-500 text-sm mt-2">Belum ada file identitas ter-upload.</p>
                @endif
                @error('file_identitas')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

        </div>    
        
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Update</button>
            <a href="{{ route('pelanggan') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

@endsection