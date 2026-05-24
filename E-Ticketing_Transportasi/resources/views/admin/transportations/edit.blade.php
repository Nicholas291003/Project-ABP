@extends('layouts.admin')

@section('content')
<div class="flex-1 overflow-y-auto p-6 lg:p-8 bg-gray-50 pb-24">
    
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Edit Data Transportasi</h1>
            <p class="text-sm text-gray-500 mt-1">Masukkan detail armada yang akan diubah.</p>
        </div>
        <a href="{{ route('admin.transportations.index') }}" class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex items-center">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 lg:p-8 max-w-4xl">
        <form action="{{ route('admin.transportations.update', $transportation->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 border-gray-100">Informasi Kendaraan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis <span class="text-red-500">*</span></label>
                    <select name="jenis" id="select_jenis" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition">
                        <option value="" disabled selected>Pilih Jenis Kendaraan</option>
                        <option value="kereta" {{ old('jenis') == 'kereta' ? 'selected' : '' }}>Kereta Api</option>
                        <option value="bus" {{ old('jenis') == 'bus' ? 'selected' : '' }}>Bus / Travel</option>
                        <option value="pesawat" {{ old('jenis') == 'pesawat' ? 'selected' : '' }}>Pesawat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Transportasi <span class="text-red-500">*</span></label>
                    <div class="flex shadow-sm rounded-lg overflow-hidden">
                        <select name="kode_prefix" id="kode_prefix" required class="bg-gray-200 border border-gray-300 border-r-0 text-gray-700 text-sm rounded-l-lg focus:ring-1 focus:ring-primary focus:border-primary px-3 py-2.5 font-bold focus:outline-none">
                            <option value="TRN" {{ old('kode_prefix') == 'TRN' ? 'selected' : '' }}>TRN</option>
                            <option value="BUS" {{ old('kode_prefix') == 'BUS' ? 'selected' : '' }}>BUS</option>
                            <option value="FLT" {{ old('kode_prefix') == 'FLT' ? 'selected' : '' }}>FLT</option>
                        </select>
                        <input type="text" name="kode_suffix" required placeholder="Contoh: 002" value="{{ old('kode_suffix') }}" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-r-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition uppercase focus:outline-none">
                    </div>
                    @error('kode')
                        <p class="text-xs text-red-600 font-semibold mt-1.5 bg-red-50 p-2 rounded border border-red-200">
                            <i class="fa-solid fa-triangle-exclamation mr-0.5"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Transportasi <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Argo Lawu" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition">
                        <option value="" disabled selected>Pilih Kelas Layanan</option>
                        <option value="Economy" {{ old('kelas') == 'Economy' ? 'selected' : '' }}>Economy</option>
                        <option value="Eksekutif" {{ old('kelas') == 'Eksekutif' ? 'selected' : '' }}>Eksekutif</option>
                        <option value="Luxury" {{ old('kelas') == 'Luxury' ? 'selected' : '' }}>Luxury</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Kursi Tersedia <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_kursi" value="{{ old('jumlah_kursi') }}" required min="1" placeholder="0" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Operasional <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition">
                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>Dalam Perbaikan (Maintenance)</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Fasilitas Kendaraan</label>
                <textarea name="fasilitas" rows="3" placeholder="Contoh: AC, Reclining Seat, Makan/Snack, Toilet..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-lg focus:bg-white focus:ring-2 focus:ring-primary focus:border-primary transition">{{ old('fasilitas') }}</textarea>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.transportations.index') }}" 
                class="px-5 py-2.5 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition">
                Batal
                </a>
                <button type="submit" class="bg-primary hover:bg-primaryDark text-white px-6 py-2.5 rounded-lg font-bold transition shadow-md flex items-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('select_jenis').addEventListener('change', function() {
        const jenisKendaraan = this.value;
        const selectPrefix = document.getElementById('kode_prefix');

        if (jenisKendaraan === 'kereta') {
            selectPrefix.value = 'TRN';
        } else if (jenisKendaraan === 'bus') {
            selectPrefix.value = 'BUS';
        } else if (jenisKendaraan === 'pesawat') {
            selectPrefix.value = 'FLT';
        }
    });
</script>
@endsection