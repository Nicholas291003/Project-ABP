@extends('layouts.passenger')

@section('title', 'Kelola Akun Profil')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    {{-- Header Halaman --}}
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Kelola Akun Profil</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui informasi data pribadi dan kata sandi keamanan Anda.</p>
    </div>

    {{-- Formulir Pembaruan Profile Glassmorphism --}}
    <div class="bg-white/80 border border-white/50 backdrop-blur-md rounded-3xl p-6 sm:p-8 shadow-xl shadow-zinc-200/40">
        <form action="{{ route('passenger.profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-5">
                {{-- Input Nama Lengkap --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Input Alamat Email --}}
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-800 font-bold focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                </div>

                {{-- Pembatas Seksi Kata Sandi Baru --}}
                <div class="pt-4 border-t border-slate-100">
                    <div class="flex items-center space-x-2 text-orange-500">
                        <i data-lucide="lock" class="w-4 h-4 stroke-[2.5px]"></i>
                        <p class="text-xs font-black uppercase tracking-wider">Ubah Kata Sandi <span class="text-[10px] font-medium text-slate-400 lowercase">(kosongkan jika tidak diganti)</span></p>
                    </div>
                </div>

                {{-- Grid Form Password --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Password Baru</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-800 focus:outline-none focus:border-teal-400 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi Simpan --}}
            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="flex items-center space-x-2 px-6 py-2.5 rounded-xl bg-gradient-to-r from-teal-400 to-indigo-500 text-white text-sm font-extrabold hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-indigo-500/10 cursor-pointer">
                    <i data-lucide="save" class="w-4.5 h-4.5 stroke-[2.5px]"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection