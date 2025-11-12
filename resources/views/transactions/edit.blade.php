@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">✏️ Edit Transaksi</h1>
        <p class="text-silver">Perbarui data transaksi</p>
    </div>

    <div class="card-premium p-8 rounded-xl">
        <form method="POST" action="{{ route('transactions.update', $transaction) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Tipe Transaksi</label>
                <select name="type" class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                    <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }} class="bg-dark-gray">📈 Pemasukan</option>
                    <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }} class="bg-dark-gray">📉 Pengeluaran</option>
                </select>
                @error('type')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Jumlah (Rp)</label>
                <input type="number" name="amount" value="{{ old('amount', $transaction->amount) }}" step="0.01"
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('amount')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Kategori</label>
                <input type="text" name="category" value="{{ old('category', $transaction->category) }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('category')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Deskripsi (Opsional)</label>
                <textarea name="description" rows="3" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition">{{ old('description', $transaction->description) }}</textarea>
                @error('description')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Tanggal</label>
                <input type="date" name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('transaction_date')
                    <p class="text-purple-400 text-sm mt-2 flex items-center gap-1">
                        <span>⚠️</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 btn-gold px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    ✨ Update Transaksi
                </button>
                <a href="{{ route('transactions.index') }}" class="flex-1 text-center gradient-purple text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
                    ← Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
