@extends('layout.app')

@section('title', 'Tambah Penjualan')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Tambah Penjualan</span>
</div>

@if ($message = Session::get('error'))
    <div class="flex items-center justify-center my-8">
        <p class="text-red-700 bg-red-100 py-2.5 px-5 rounded-lg">
           <span class="font-medium">{{ $message }}</span>. Silahkan coba lagi nanti.
        </p>
    </div>
@endif

<hr class="mt-4">

<div class="p-4 mt-4">
    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        {{-- Input tanggal pembelian --}}
        <div class="flex flex-row items-center mb-4">
            <div class="basis-2/12">
                <label for="tanggal_penjualan" class="block mb-2 text-base font-medium text-gray-900">
                    <div class="flex justify-between">
                        <div>Tanggal Pembelian</div>
                        <div>:</div>
                    </div>
                </label>
            </div>

            <div class="basis-4/12 ps-2">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input datepicker type="text" id="tanggal_penjualan" name="tanggal_penjualan" value="{{ old('tanggal_penjualan') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full ps-10 p-2.5" placeholder="Pilih tanggal pembelian">
                </div>              
                @error('tanggal_penjualan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Input nama pelanggan --}}
        <div class="flex flex-row items-center mb-4">
            <div class="basis-2/12 w-48">
                <label for="pelanggan" class="block mb-2 text-base font-medium text-gray-900">
                    <div class="flex justify-between">
                        <div>Nama Pelanggan</div>
                        <div>:</div>
                    </div>
                </label>
            </div>

            <div class="basis-4/12 ps-2">
                <select id="pelanggan" name="pelanggan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled selected>Pilih nama pelanggan</option>
                    @foreach ($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->id_pelanggan }}">{{ $pelanggan->nama_pelanggan }}</option>
                    @endforeach
                </select>
                @error('pelanggan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Input barang --}}
        <div id="barang-container" class="flex flex-row items-start mb-4">
            <div class="basis-2/12">
                <label for="barang" class="block mb-2 text-base font-medium text-gray-900">
                    <div class="flex justify-between">
                        <div>Barang</div>
                        <div>:</div>
                    </div>
                </label>
            </div>

            <div class="basis-10/12 ps-2">
                <div class="relative border border-gray-200 rounded-lg overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs border-b text-gray-700 bg-gray-100 uppercase dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="p-4 w-12">No</th>
                                <th scope="col" class="px-4 py-3 w-9/12">Nama Barang</th>
                                <th scope="col" class="px-4 py-3">Kuantitas</th>
                                <th scope="col" class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="barang-rows">
                            <tr class="bg-white border-b">
                                <td scope="col" class="p-4 nomor">1</td>
                                <td scope="col" class="px-4 py-3">
                                    <select id="barang" name="barangs[0][id]" class="bg-gray-50 border w-full border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5">
                                        <option value="" disabled selected>Pilih barang</option>
                                        @foreach ($barangs as $barang)
                                           <option value="{{ $barang->id_barang }}" data-harga="{{ $barang->harga }}" data-stok="{{ $barang->stok }}">{{ $barang->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td scope="col" class="px-4 py-3">
                                    <input type="number" id="kuantitas" name="barangs[0][kuantitas]" value="{{ old('kuantitas') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5" placeholder="Masukkan kuantitas" />
                                </td>
                                <td scope="col" class="px-4 py-3 text-center">
                                    <button type="button" class="remove-barang-btn text-red-500 hover:text-red-700">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-end p-4">
                        <button type="button" id="add-barang-btn" class="text-white bg-green-500 hover:bg-green-600 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tambah Barang</button>
                    </div>
                </div>
                @error('barangs')
                <div class="flex-none">
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                </div>
                @enderror
            </div>
        </div>   

        {{-- Input total harga --}}
        <div class="flex flex-row items-center mb-4">
            <div class="basis-2/12 w-48">
                <label for="total_harga" class="block mb-2 text-base font-medium text-gray-900">
                    <div class="flex justify-between">
                        <div>Total Harga</div>
                        <div>:</div>
                    </div>
                </label>
            </div>

            <div class="basis-4/12 ps-2">
                <input type="text" id="total_harga" name="total_harga" value="{{ old('total_harga') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Total harga akan muncul otomatis" disabled />
                @error('total_harga')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Input uang muka --}}
        <div class="flex flex-row items-center mb-4">
            <div class="basis-2/12 w-48">
                <label for="down_payment" class="block mb-2 text-base font-medium text-gray-900">
                    <div class="flex justify-between">
                        <div>Uang Muka</div>
                        <div>:</div>
                    </div>
                </label>
            </div>

            <div class="basis-4/12 ps-2">
                <input type="number" id="down_payment" name="down_payment" value="{{ old('down_payment') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan jumlah uang muka" />
                @error('down_payment')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        {{-- Input jangka pembayaran --}}
        <div class="flex flex-row items-center mb-4">
            <div class="basis-2/12 w-48">
                <label for="jangka_pembayaran" class="block mb-2 text-base font-medium text-gray-900">
                    <div class="flex justify-between">
                        <div>Jangka Pembayaran (bulan)</div>
                        <div>:</div>
                    </div>
                </label>
            </div>

            <div class="basis-4/12 ps-2">
                <input type="number" id="jangka_pembayaran" name="jangka_pembayaran" value="{{ old('jangka_pembayaran') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan jangka waktu pembayaran" />
                @error('jangka_pembayaran')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        
        <hr class="my-8">

        <div class="flex items-center justify-end gap-2 pt-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tambah</button>
            <a href="{{ route('penjualan') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    let barangIndex = 1;

    function updateTotalHarga() {
        let totalHarga = 0;

        document.querySelectorAll('select[name^="barangs"]').forEach(select => {
            const kuantitasInput = select.closest('tr').querySelector('input[name^="barangs"][name$="[kuantitas]"]');
            const harga = select.selectedOptions[0].dataset.harga || 0;
            const kuantitas = kuantitasInput.value || 0;

            totalHarga += harga * kuantitas;
        });

        document.getElementById('total_harga').value = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalHarga);
    }

    function updateRowNumbers() {
        document.querySelectorAll('#barang-rows tr').forEach((row, index) => {
            row.querySelector('.nomor').textContent = index + 1;
        });
    }

    function checkStockAndAdjustQuantity(selectElement) {
        const selectedOption = selectElement.selectedOptions[0];
        const stok = selectedOption.dataset.stok || 0;
        const kuantitasInput = selectElement.closest('tr').querySelector('input[name^="barangs"][name$="[kuantitas]"]');
        
        if (parseInt(kuantitasInput.value) > parseInt(stok)) {
            kuantitasInput.value = stok;
            alert('Kuantitas yang dimasukkan melebihi stok yang tersedia. Kuantitas telah disesuaikan dengan stok yang tersedia.');
        }
    }

    document.getElementById('add-barang-btn').addEventListener('click', function () {
        const newRow = document.createElement('tr');
        newRow.classList.add('bg-white', 'border-b');
        newRow.innerHTML = `
            <td class="p-4 nomor">${barangIndex + 1}</td>
            <td class="px-4 py-3">
                <select name="barangs[${barangIndex}][id]" class="bg-gray-50 border w-full border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5">
                    <option value="" disabled selected>Pilih barang</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id_barang }}" data-harga="{{ $barang->harga }}" data-stok="{{ $barang->stok }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </td>
            <td class="px-4 py-3">
                <input type="number" name="barangs[${barangIndex}][kuantitas]" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block p-2.5" placeholder="Masukkan kuantitas" />
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="remove-barang-btn text-red-500 hover:text-red-700">Hapus</button>
            </td>
        `;
        document.getElementById('barang-rows').appendChild(newRow);
        barangIndex++;

        newRow.querySelector('select').addEventListener('change', function() {
            updateTotalHarga();
            checkStockAndAdjustQuantity(this);
        });
        newRow.querySelector('input').addEventListener('input', updateTotalHarga);
        updateRowNumbers();
    });

    document.getElementById('barang-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-barang-btn')) {
            e.target.closest('tr').remove();
            barangIndex--;
            updateTotalHarga();
            updateRowNumbers();
        }
    });

    document.querySelectorAll('select[name^="barangs"]').forEach(select => {
        select.addEventListener('change', function() {
            updateTotalHarga();
            checkStockAndAdjustQuantity(this);
        });
    });

    document.querySelectorAll('input[name^="barangs"][name$="[kuantitas]"]').forEach(input => {
        input.addEventListener('input', updateTotalHarga);
    });

    updateTotalHarga();

    // Fungsi untuk menampilkan popup peringatan jika kuantitas melebihi stok
    function showStockWarning(element) {
        const namaBarang = element.options[element.selectedIndex].text;
        const stokBarang = parseInt(element.options[element.selectedIndex].dataset.stok);
        let kuantitas = parseInt(element.closest('tr').querySelector('input[name^="barangs"][name$="[kuantitas]"]').value);

        if (kuantitas > stokBarang) {
            alert(`Kuantitas ${namaBarang} melebihi stok yang tersedia (${stokBarang}). Akan diatur menjadi ${stokBarang}.`);
            kuantitas = stokBarang;
            element.closest('tr').querySelector('input[name^="barangs"][name$="[kuantitas]"]').value = kuantitas;
        }
    }

    // Event listener untuk setiap select barang
    document.querySelectorAll('select[name^="barangs"]').forEach(select => {
        select.addEventListener('change', function () {
            showStockWarning(this);
            updateTotalHarga();
        });
    });

    // Event listener untuk setiap input kuantitas
    document.querySelectorAll('input[name^="barangs"][name$="[kuantitas]"]').forEach(input => {
        input.addEventListener('input', function () {
            const select = this.closest('tr').querySelector('select[name^="barangs"]');
            showStockWarning(select);
            updateTotalHarga();
        });
    });


    // Event listener untuk form submit
    document.querySelector('form').addEventListener('submit', function (event) {
        let valid = true;
        document.querySelectorAll('select[name^="barangs"]').forEach(select => {
            const kuantitas = parseInt(select.closest('tr').querySelector('input[name^="barangs"][name$="[kuantitas]"]').value);
            const stok = parseInt(select.selectedOptions[0].dataset.stok);
            if (kuantitas > stok) {
                showStockWarning(select);
                valid = false;
            }
        });

        if (!valid) {
            event.preventDefault(); // Menghentikan pengiriman form jika ada kesalahan
        }
    });
});

</script>
@endsection
