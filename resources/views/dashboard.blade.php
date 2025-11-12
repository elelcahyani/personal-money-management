@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gold mb-2">Dashboard</h1>
    <p class="text-silver">Selamat datang, <span class="text-gold font-semibold">{{ auth()->user()->name }}</span>!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card-premium p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-silver text-sm uppercase tracking-wide">Total Pemasukan</h3>
            <span class="text-2xl">📈</span>
        </div>
        <p class="text-3xl font-bold text-gold">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
    </div>
    <div class="card-premium p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-silver text-sm uppercase tracking-wide">Total Pengeluaran</h3>
            <span class="text-2xl">📉</span>
        </div>
        <p class="text-3xl font-bold" style="color: #9B59B6;">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
    </div>
    <div class="card-premium p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-silver text-sm uppercase tracking-wide">Saldo</h3>
            <span class="text-2xl">💎</span>
        </div>
        <p class="text-3xl font-bold {{ $balance >= 0 ? 'text-gold' : '' }}" style="{{ $balance < 0 ? 'color: #9B59B6;' : '' }}">
            Rp {{ number_format($balance, 0, ',', '.') }}
        </p>
    </div>
</div>

<!-- Chart Section -->
<div class="card-premium p-6 rounded-xl mb-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gold">📊 Grafik Transaksi</h2>
        <div class="flex gap-4 items-center">
            <form method="GET" action="{{ route('dashboard') }}" class="flex gap-2 items-center">
                <select name="period" id="periodSelect" class="px-4 py-2 bg-dark-card border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold" onchange="toggleCustomDate()">
                    <option value="7days" {{ $period == '7days' ? 'selected' : '' }}>7 Hari Terakhir</option>
                    <option value="30days" {{ $period == '30days' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    <option value="90days" {{ $period == '90days' ? 'selected' : '' }}>90 Hari Terakhir</option>
                    <option value="1year" {{ $period == '1year' ? 'selected' : '' }}>1 Tahun Terakhir</option>
                    <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
                
                <div id="customDateRange" class="flex gap-2" style="display: {{ $period == 'custom' ? 'flex' : 'none' }}">
                    <input type="date" name="start_date" value="{{ $startDate }}" class="px-4 py-2 bg-dark-card border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                    <input type="date" name="end_date" value="{{ $endDate }}" class="px-4 py-2 bg-dark-card border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold">
                </div>
                
                <button type="submit" class="btn-gold px-6 py-2 rounded-lg transition transform hover:scale-105">
                    🔍 Filter
                </button>
            </form>
            
            <a href="{{ route('dashboard.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
               class="gradient-purple text-white px-6 py-2 rounded-lg hover:opacity-90 transition transform hover:scale-105 flex items-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </a>
        </div>
    </div>
    
    <canvas id="transactionChart" height="80"></canvas>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="card-premium p-6 rounded-xl">
        <h2 class="text-xl font-bold text-gold mb-4">💰 Transaksi Terakhir</h2>
        @forelse($recentTransactions as $transaction)
            <div class="flex justify-between items-center py-3 border-b border-gold hover:bg-hover transition rounded-lg px-2">
                <div>
                    <p class="font-semibold text-silver">{{ $transaction->category }}</p>
                    <p class="text-sm text-gray-400">{{ $transaction->transaction_date->format('d M Y') }}</p>
                </div>
                <p class="font-bold {{ $transaction->type == 'income' ? 'text-gold' : '' }}" style="{{ $transaction->type == 'expense' ? 'color: #9B59B6;' : '' }}">
                    {{ $transaction->type == 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-4xl mb-2">📊</div>
                <p class="text-gray-400 text-sm mb-3">Belum ada transaksi</p>
                <a href="{{ route('transactions.create') }}" class="text-gold hover:text-yellow-400 font-semibold text-sm transition">
                    ✨ Tambah Transaksi
                </a>
            </div>
        @endforelse
        @if($recentTransactions->count() > 0)
            <a href="{{ route('transactions.index') }}" class="block mt-4 text-gold hover:text-yellow-400 transition font-semibold">→ Lihat Semua</a>
        @endif
    </div>

    <div class="card-premium p-6 rounded-xl">
        <h2 class="text-xl font-bold text-gold mb-4">🎯 Goals Aktif</h2>
        @forelse($activeGoals as $goal)
            <div class="mb-4">
                <div class="flex justify-between mb-1">
                    <p class="font-semibold text-silver">{{ $goal->title }}</p>
                    <p class="text-sm text-gold font-bold">{{ number_format(($goal->current_amount / $goal->target_amount) * 100, 0) }}%</p>
                </div>
                <div class="w-full bg-dark-gray rounded-full h-3 border border-gold">
                    @php
                        $progress = min(($goal->current_amount / $goal->target_amount) * 100, 100);
                    @endphp
                    <div class="gradient-gold h-3 rounded-full shadow-lg" style="width: {{ $progress }}%"></div>
                </div>
                <p class="text-sm text-gray-400 mt-2">
                    <span class="text-gold font-semibold">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span> / Rp {{ number_format($goal->target_amount, 0, ',', '.') }}
                </p>
            </div>
        @empty
            <div class="text-center py-8">
                <div class="text-4xl mb-2">🎯</div>
                <p class="text-gray-400 text-sm mb-3">Belum ada goals</p>
                <a href="{{ route('goals.create') }}" class="text-gold hover:text-yellow-400 font-semibold text-sm transition">
                    ✨ Buat Goal
                </a>
            </div>
        @endforelse
        @if($activeGoals->count() > 0)
            <a href="{{ route('goals.index') }}" class="block mt-4 text-gold hover:text-yellow-400 transition font-semibold">→ Lihat Semua</a>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function toggleCustomDate() {
    const period = document.getElementById('periodSelect').value;
    const customDateRange = document.getElementById('customDateRange');
    customDateRange.style.display = period === 'custom' ? 'flex' : 'none';
}

// Debug: Log chart data
const chartData = {
    labels: @json($chartData['labels']),
    income: @json($chartData['income']),
    expense: @json($chartData['expense'])
};
console.log('Chart Data:', chartData);

const ctx = document.getElementById('transactionChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.labels,
        datasets: [
            {
                label: 'Pemasukan',
                data: chartData.income,
                borderColor: '#FFD700',
                backgroundColor: 'rgba(255, 215, 0, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: '#FFD700',
                pointBorderColor: '#FFA500',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            },
            {
                label: 'Pengeluaran',
                data: chartData.expense,
                borderColor: '#9B59B6',
                backgroundColor: 'rgba(155, 89, 182, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 3,
                pointBackgroundColor: '#9B59B6',
                pointBorderColor: '#8E44AD',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#EFEFEF',
                    font: {
                        size: 14,
                        weight: 'bold'
                    },
                    padding: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                        return label;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(255, 215, 0, 0.1)',
                    borderColor: 'rgba(255, 215, 0, 0.3)'
                },
                ticks: {
                    color: '#EFEFEF',
                    font: {
                        size: 12
                    },
                    callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            x: {
                grid: {
                    color: 'rgba(255, 215, 0, 0.05)',
                    borderColor: 'rgba(255, 215, 0, 0.3)'
                },
                ticks: {
                    color: '#EFEFEF',
                    font: {
                        size: 12
                    }
                }
            }
        }
    }
});
</script>
@endsection
