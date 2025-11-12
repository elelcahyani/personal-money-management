@extends('layouts.app')

@section('title', 'Goals')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold text-gold mb-2">Goals</h1>
        <p class="text-silver">Tetapkan dan capai target keuanganmu</p>
    </div>
    <div class="flex gap-3 items-center">
        <button onclick="toggleGridLayout()" id="gridToggle" class="bg-dark-gray px-4 py-2 rounded-lg border border-gold hover:bg-hover transition">
            <svg id="gridIcon" class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 20 20">
                <rect x="2" y="2" width="7" height="16" rx="1"/>
                <rect x="11" y="2" width="7" height="16" rx="1"/>
            </svg>
        </button>
        <a href="{{ route('goals.create') }}" class="btn-gold px-6 py-3 rounded-lg transition transform hover:scale-105 flex items-center gap-2">
            <span class="text-xl">+</span> Tambah Goal
        </a>
    </div>
</div>

<div id="goalsGrid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @forelse($goals as $goal)
        <div class="card-premium p-6 rounded-xl">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-gold mb-2">{{ $goal->title }}</h3>
                    <p class="text-gray-400 text-sm">{{ $goal->description }}</p>
                </div>
                <span class="px-3 py-1 text-xs rounded-full font-semibold ml-2 {{ $goal->status == 'active' ? 'bg-gold text-midnight-blue' : ($goal->status == 'completed' ? 'gradient-purple text-white' : 'bg-dark-gray text-silver') }}">
                    {{ $goal->status == 'active' ? 'Active' : ($goal->status == 'completed' ? 'Completed' : 'Cancelled') }}
                </span>
            </div>

            <div class="mb-6">
                <div class="flex justify-between mb-2">
                    <span class="text-sm text-silver uppercase tracking-wide">Progress</span>
                    <span class="text-lg font-bold text-gold">{{ number_format(($goal->current_amount / $goal->target_amount) * 100, 0) }}%</span>
                </div>
                <div class="w-full bg-dark-gray rounded-full h-4 border border-gold">
                    @php
                        $progress = min(($goal->current_amount / $goal->target_amount) * 100, 100);
                    @endphp
                    <div class="gradient-gold h-4 rounded-full shadow-lg transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>
                <div class="flex justify-between mt-3">
                    <span class="text-sm text-silver">
                        <span class="text-gold font-bold text-lg">Rp {{ number_format($goal->current_amount, 0, ',', '.') }}</span>
                    </span>
                    <span class="text-sm text-gray-400">
                        Target: <span class="text-silver font-semibold">Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span>
                    </span>
                </div>
            </div>

            @if($goal->target_date)
                <div class="flex items-center gap-2 mb-4 text-sm">
                    <span class="text-silver">Target: <span class="text-gold font-semibold">{{ $goal->target_date->format('d M Y') }}</span></span>
                </div>
            @endif

            <div class="flex gap-2">
                <a href="{{ route('goals.edit', $goal) }}" class="flex-1 text-center gradient-gold text-midnight-blue px-4 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
                    Edit
                </a>
                <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full gradient-purple text-white px-4 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg" onclick="return confirm('Yakin ingin menghapus?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-full card-premium rounded-xl p-12">
            <div class="text-center animate-bounce-slow">
                <h3 class="text-2xl font-bold text-gold mb-2">Yah, Masih Kosong!</h3>
                <p class="text-silver mb-6">Belum ada target keuangan. Yuk, tetapkan goal pertamamu dan wujudkan impianmu!</p>
                <a href="{{ route('goals.create') }}" class="inline-block btn-gold px-8 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    Buat Goal Pertamamu
                </a>
            </div>
        </div>
    @endforelse
</div>

<script>
    let currentLayout = 2; // Default 2 columns
    
    const icons = {
        1: '<rect x="2" y="2" width="16" height="16" rx="2"/>',
        2: '<rect x="2" y="2" width="7" height="16" rx="1"/><rect x="11" y="2" width="7" height="16" rx="1"/>',
        3: '<rect x="2" y="2" width="4.5" height="16" rx="1"/><rect x="7.75" y="2" width="4.5" height="16" rx="1"/><rect x="13.5" y="2" width="4.5" height="16" rx="1"/>'
    };
    
    function toggleGridLayout() {
        // Cycle through layouts: 2 -> 3 -> 1 -> 2
        currentLayout = currentLayout === 3 ? 1 : currentLayout + 1;
        
        const grid = document.getElementById('goalsGrid');
        const icon = document.getElementById('gridIcon');
        
        // Update icon
        icon.innerHTML = icons[currentLayout];
        
        // Update grid layout
        grid.className = 'grid grid-cols-1 gap-6';
        if (currentLayout === 2) {
            grid.classList.add('md:grid-cols-2');
        } else if (currentLayout === 3) {
            grid.classList.add('md:grid-cols-3');
        }
        
        // Save preference
        localStorage.setItem('goalsGridLayout', currentLayout);
    }
    
    // Load saved preference on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedLayout = localStorage.getItem('goalsGridLayout');
        if (savedLayout) {
            currentLayout = parseInt(savedLayout);
            const grid = document.getElementById('goalsGrid');
            const icon = document.getElementById('gridIcon');
            
            icon.innerHTML = icons[currentLayout];
            grid.className = 'grid grid-cols-1 gap-6';
            if (currentLayout === 2) {
                grid.classList.add('md:grid-cols-2');
            } else if (currentLayout === 3) {
                grid.classList.add('md:grid-cols-3');
            }
        }
    });
</script>
@endsection
