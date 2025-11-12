@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">Profile</h1>
        <p class="text-silver">Kelola informasi akun dan keamanan</p>
    </div>

    <!-- Profile Info Card -->
    <div class="card-premium p-8 rounded-xl mb-6">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-gold to-yellow-600 flex items-center justify-center text-midnight-blue text-3xl font-bold shadow-lg">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gold">{{ auth()->user()->name }}</h2>
                <p class="text-silver">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="border-t border-gold border-opacity-20 pt-6">
            <h3 class="text-xl font-bold text-gold mb-4">Informasi Profile</h3>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')
                
                <div class="mb-6">
                    <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Nama</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                        class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                    @error('name')
                        <p class="text-purple-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Email</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                        class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                    @error('email')
                        <p class="text-purple-400 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-gold px-8 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    Update Profile
                </button>
            </form>
        </div>
    </div>

    <!-- Password Card -->
    <div class="card-premium p-8 rounded-xl mb-6">
        <h3 class="text-xl font-bold text-gold mb-6">Ubah Password</h3>
        <form method="POST" action="{{ route('profile.password') }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Password Saat Ini</label>
                <input type="password" name="current_password" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('current_password')
                    <p class="text-purple-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Password Baru</label>
                <input type="password" name="password" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('password')
                    <p class="text-purple-400 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-gray-400 text-sm mt-2">Minimal 8 karakter</p>
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
            </div>

            <button type="submit" class="gradient-purple text-white px-8 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                Ubah Password
            </button>
        </form>
    </div>

    <!-- Logout Card -->
    <div class="card-premium p-8 rounded-xl border-red-600 border-opacity-30">
        <h3 class="text-xl font-bold text-gold mb-4">Keluar dari Akun</h3>
        <p class="text-silver mb-6">Anda akan keluar dari akun dan kembali ke halaman login.</p>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection
