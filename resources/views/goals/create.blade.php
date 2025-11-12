@extends('layouts.app')

@section('title', 'Tambah Goal')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">🎯 Tambah Goal</h1>
        <p class="text-silver">Tetapkan target keuanganmu</p>
    </div>

    <div class="card-premium p-8 rounded-xl">
        <form method="POST" action="{{ route('goals.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Judul Goal</label>
                <input type="text" name="title" value="{{ old('title') }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition placeholder-gray-500" 
                    placeholder="Contoh: Beli Laptop, Dana Darurat" required>
                @error('title')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition placeholder-gray-500" 
                    placeholder="Jelaskan tujuan goal ini...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Target Jumlah (Rp)</label>
                <input type="number" name="target_amount" value="{{ old('target_amount') }}" step="0.01"
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition placeholder-gray-500" 
                    placeholder="Contoh: 10000000" required>
                @error('target_amount')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Target Tanggal (Opsional)</label>
                <input type="date" name="target_date" value="{{ old('target_date') }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition">
                @error('target_date')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 btn-gold px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    ✨ Simpan Goal
                </button>
                <a href="{{ route('goals.index') }}" class="flex-1 text-center gradient-purple text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
