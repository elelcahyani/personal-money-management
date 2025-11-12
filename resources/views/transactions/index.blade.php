@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold text-gold mb-2">Transaksi</h1>
        <p class="text-silver">Kelola semua transaksi keuanganmu</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn-gold px-6 py-3 rounded-lg transition transform hover:scale-105 flex items-center gap-2">
        <span class="text-xl">+</span> Tambah Transaksi
    </a>
</div>

<!-- Filter Section -->
<div class="card-premium p-6 rounded-xl mb-6">
    <!-- Quick Filters -->
    <div class="flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('transactions.index', ['start_date' => now()->startOfDay()->format('Y-m-d'), 'end_date' => now()->format('Y-m-d')]) }}" 
           class="px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg hover:bg-gold hover:text-midnight-blue transition text-sm font-semibold">
            Hari Ini
        </a>
        <a href="{{ route('transactions.index', ['start_date' => now()->startOfWeek()->format('Y-m-d'), 'end_date' => now()->endOfWeek()->format('Y-m-d')]) }}" 
           class="px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg hover:bg-gold hover:text-midnight-blue transition text-sm font-semibold">
            Minggu Ini
        </a>
        <a href="{{ route('transactions.index', ['start_date' => now()->startOfMonth()->format('Y-m-d'), 'end_date' => now()->endOfMonth()->format('Y-m-d')]) }}" 
           class="px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg hover:bg-gold hover:text-midnight-blue transition text-sm font-semibold">
            Bulan Ini
        </a>
        <a href="{{ route('transactions.index', ['start_date' => now()->startOfYear()->format('Y-m-d'), 'end_date' => now()->endOfYear()->format('Y-m-d')]) }}" 
           class="px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg hover:bg-gold hover:text-midnight-blue transition text-sm font-semibold">
            Tahun Ini
        </a>
    </div>
    
    <div class="border-t border-gold border-opacity-20 mb-4"></div>
    
    <form method="GET" action="{{ route('transactions.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label class="block text-gold text-sm font-semibold mb-2">Tanggal Mulai</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                class="w-full px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
        </div>
        
        <div>
            <label class="block text-gold text-sm font-semibold mb-2">Tanggal Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                class="w-full px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
        </div>
        
        <div>
            <label class="block text-gold text-sm font-semibold mb-2">Tipe</label>
            <select name="type" class="w-full px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Semua</option>
                <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
            </select>
        </div>
        
        <div>
            <label class="block text-gold text-sm font-semibold mb-2">Kategori</label>
            <input type="text" name="category" value="{{ request('category') }}" placeholder="Cari kategori..." 
                class="w-full px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold placeholder-gray-500">
        </div>
        
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 btn-gold px-6 py-2 rounded-lg transition transform hover:scale-105 font-semibold">
                Cari
            </button>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-dark-gray border border-gold text-silver rounded-lg hover:bg-hover transition font-semibold">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="card-premium rounded-xl overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-dark-gray border-b border-gold">
            <tr>
                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-wider">Deskripsi</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-wider">Tipe</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-wider">Jumlah</th>
                <th class="px-6 py-4 text-left text-xs font-bold text-gold uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gold divide-opacity-10">
            @forelse($transactions as $transaction)
                <tr class="hover:bg-hover transition">
                    <td class="px-6 py-4 text-silver">{{ $transaction->transaction_date->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-silver font-semibold">{{ $transaction->category }}</td>
                    <td class="px-6 py-4 text-gray-400">{{ $transaction->description ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $transaction->type == 'income' ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
                            {{ $transaction->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-lg {{ $transaction->type == 'income' ? 'text-gold' : 'text-purple-400' }}">
                        {{ $transaction->type == 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('transactions.edit', $transaction) }}" class="text-gold hover:text-yellow-400 transition font-semibold">Edit</a>
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-purple-400 hover:text-purple-300 transition font-semibold" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-16">
                        <div class="text-center animate-bounce-slow">
                            <h3 class="text-2xl font-bold text-gold mb-2">Yah, Masih Kosong!</h3>
                            <p class="text-silver mb-6">Belum ada transaksi yang tercatat. Mulai catat keuanganmu sekarang!</p>
                            <a href="{{ route('transactions.create') }}" class="inline-block btn-gold px-8 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                                Buat Transaksi Pertamamu
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $transactions->appends(request()->query())->links() }}
</div>
@endsection
