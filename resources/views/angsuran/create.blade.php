@extends('layout.app')

@section('title', 'Angsuran')

@section('content')

<div>
    <span class="text-xl font-medium text-gray-600">Tambah Data Angsuran</span>
</div>

@if ($errors->any())
    <div class="flex items-center justify-center my-8">
        <p class="text-red-700 bg-red-100 py-2.5 px-5 rounded-lg">
            <span class="font-medium">Terjadi kesalahan:</span> {{ $errors->first() }}
        </p>
    </div>
@endif

<div class="border rounded-lg p-4 mt-4">
    <form action="{{ route('angsuran.store') }}" method="POST">
        @csrf
        <div class="grid gap-6 mb-6 md:grid-cols-2">
            <div>
                <label for="id_penjualan" class="block mb-2 text-base font-medium text-gray-900">ID Penjualan Kredit</label>
                <select id="id_penjualan" name="id_penjualan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="" disabled selected>Pilih ID Penjualan Kredit</option>
                    @foreach ($penjualanKredits as $penjualanKredit)
                        <option value="{{ $penjualanKredit->id_penjualan_kredit }}" data-jangka="{{ $penjualanKredit->jangka_pembayaran }}" data-pelanggan="{{ $penjualanKredit->pelanggan->nama_pelanggan }}" data-total="{{ $penjualanKredit->total_angsur_bulanan }}" data-sale-date="{{ $penjualanKredit->tanggal_penjualan }}">
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
                    <input datepicker type="text" id="tanggal" name="tanggal" value="{{ old('tanggal') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full pl-10 p-2.5" placeholder="Pilih tanggal pembayaran angsuran">
                </div>              
                @error('tanggal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="pelanggan" class="block mb-2 text-base font-medium text-gray-900">Nama Pelanggan</label>
                <input type="text" id="pelanggan" name="pelanggan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Nama pelanggan otomatis muncul" readonly />
                @error('pelanggan')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="angsuran_ke" class="block mb-2 text-base font-medium text-gray-900">Angsuran ke</label>
                <select id="angsuran_ke" name="angsuran_ke" class="bg-gray-50 border  border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5"></select>
                @error('angsuran_ke')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="nominal" class="block mb-2 text-base font-medium text-gray-900">Nominal Angsuran</label>
                <input type="text" id="nominal" name="nominal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5" placeholder="Masukkan nominal pembayaran angsuran" readonly />
                @error('nominal')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Tambah</button>
            <a href="{{ route('angsuran') }}" class="text-gray-900 bg-gray-200 hover:bg-gray-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Batal</a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const penjualanSelect = document.getElementById('id_penjualan');
        const pelangganInput = document.getElementById('pelanggan');
        const angsuranSelect = document.getElementById('angsuran_ke');
        const nominalInput = document.getElementById('nominal');
        const tanggalInput = document.getElementById('tanggal');

        penjualanSelect.addEventListener('change', function() {
            const selectedOption = penjualanSelect.options[penjualanSelect.selectedIndex];
            const jangkaPembayaran = selectedOption.getAttribute('data-jangka');
            const pelanggan = selectedOption.getAttribute('data-pelanggan');
            const totalAngsurBulanan = selectedOption.getAttribute('data-total');

            pelangganInput.value = pelanggan;
            nominalInput.value = totalAngsurBulanan;

            fetch(`/angsuran/remaining/${selectedOption.value}`)
                .then(response => response.json())
                .then(data => {
                    angsuranSelect.innerHTML = '';
                    for (let i = 1; i <= jangkaPembayaran; i++) {
                        if (!data.includes(i)) {
                            const option = document.createElement('option');
                            option.value = i;
                            option.textContent = `Angsuran ke-${i}`;
                            angsuranSelect.appendChild(option);
                        }
                    }
                });

            fetch(`/angsuran/last-payment-date/${selectedOption.value}`)
                .then(response => response.json())
                .then(data => {
                    const lastPaymentDate = data.last_payment_date;
                    let validDate;
                    if (lastPaymentDate) {
                        validDate = new Date(lastPaymentDate);
                        validDate.setDate(validDate.getDate() + 30);
                    } else {
                        validDate = new Date(selectedOption.getAttribute('data-sale-date'));
                        validDate.setDate(validDate.getDate() + 30);
                    }
                    tanggalInput.setAttribute('min', validDate.toISOString().split('T')[0]);
                });
        });

        // Trigger change event to populate initial values
        penjualanSelect.dispatchEvent(new Event('change'));
    });
</script>

@endsection
