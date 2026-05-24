@extends('layouts.passenger')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Kelola Akun Profil</h1>
    <p class="text-sm text-gray-500 mt-1">Perbarui informasi data pribadi dan kata sandi keamanan Anda.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 max-w-2xl">
    <form action="{{ route('passenger.profile.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary transition">
            </div>
            <div class="border-t pt-4 mt-2">
                <p class="text-xs font-bold text-orange-500 uppercase tracking-wider mb-3">Ubah Kata Sandi (Kosongkan jika tidak diganti)</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                <input type="password" name="password" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary transition">
            </div>
        </div>

        <div class="flex justify-end mt-8 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-primary hover:bg-primaryDark text-white font-bold px-6 py-2.5 rounded-xl shadow-md transition">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection