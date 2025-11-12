@extends('layouts.app')

@section('title', 'Edit Goal')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">✏️ Edit Goal</h1>
        <p class="text-silver">Perbarui target keuanganmu</p>
    </div>

    <div class="card-premium p-8 rounded-xl">
        <form method="POST" action="{{ route('goals.update', $goal) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Judul Goal</label>
                <input type="text" name="title" value="{{ old('title', $goal->title) }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('title')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition">{{ old('description', $goal->description) }}</textarea>
                @error('description')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Target Jumlah (Rp)</label>
                    <input type="number" name="target_amount" value="{{ old('target_amount', $goal->target_amount) }}" step="0.01"
                        class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                    @error('target_amount')
                        <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Jumlah Saat Ini (Rp)</label>
                    <input type="number" name="current_amount" value="{{ old('current_amount', $goal->current_amount) }}" step="0.01"
                        class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                    @error('current_amount')
                        <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                            <span>⚠️</span> {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Target Tanggal (Opsional)</label>
                <input type="date" name="target_date" value="{{ old('target_date', $goal->target_date?->format('Y-m-d')) }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition">
                @error('target_date')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Status</label>
                <select name="status" class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                    <option value="active" {{ old('status', $goal->status) == 'active' ? 'selected' : '' }} class="bg-dark-gray">🔥 Active</option>
                    <option value="completed" {{ old('status', $goal->status) == 'completed' ? 'selected' : '' }} class="bg-dark-gray">✅ Completed</option>
                    <option value="cancelled" {{ old('status', $goal->status) == 'cancelled' ? 'selected' : '' }} class="bg-dark-gray">❌ Cancelled</option>
                </select>
                @error('status')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 btn-gold px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    ✨ Update Goal
                </button>
                <a href="{{ route('goals.index') }}" class="flex-1 text-center gradient-purple text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
