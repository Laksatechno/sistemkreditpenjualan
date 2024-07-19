@extends('layout.app')

@section('title', 'Tambah Pelanggan')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Tambah Pelanggan</span>
</div>

@if ($message = Session::get('error'))
    <div class="flex items-center justify-center my-8">
        <p class="text-red-700 bg-red-100 py-2.5 px-5 rounded-lg">
           <span class="font-medium">{{ $message }}</span>. Silahkan coba lagi nanti.
        </p>
    </div>
@endif

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('pelanggan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="nama" class="block mb-2 text-base font-medium text-gray-900">Nama</label>
                <input type="text" id="nama" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan nama pelanggan" />
                @error('nama_pelanggan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="telepon" class="block mb-2 text-base font-medium text-gray-900">Telepon</label>
                <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan nomor telepon"/>
                @error('telepon')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="alamat" class="block mb-2 text-base font-medium text-gray-900">Alamat</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan alamat" />
                @error('alamat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>                
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="kartu_identitas">Unggah File Scan Identitas</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="kartu_identitas_help" id="kartu_identitas" type="file" name="kartu_identitas">
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="kartu_identitas_help">PDF maks. 1MB</p>
                @error('kartu_identitas')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tambah</button>
            <a href="{{ route('pelanggan') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

@endsection
