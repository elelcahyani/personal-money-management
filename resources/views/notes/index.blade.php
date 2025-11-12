@extends('layouts.app')

@section('title', 'Catatan')

@section('content')
<style>
    .note-content b, .note-content strong {
        font-weight: bold;
    }
    .note-content i, .note-content em {
        font-style: italic;
    }
    .note-content u {
        text-decoration: underline;
    }
    .note-content strike, .note-content s {
        text-decoration: line-through;
    }
    .note-content ul {
        list-style-type: disc;
        margin-left: 20px;
        padding-left: 10px;
    }
    .note-content ol {
        list-style-type: decimal;
        margin-left: 20px;
        padding-left: 10px;
    }
    .note-content li {
        margin: 3px 0;
    }
</style>
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-4xl font-bold text-gold mb-2">Catatan</h1>
        <p class="text-silver">Catat hal penting tentang keuanganmu</p>
    </div>
    <div class="flex gap-3 items-center">
        <button onclick="toggleGridLayout()" id="gridToggle" class="bg-dark-gray px-4 py-2 rounded-lg border border-gold hover:bg-hover transition">
            <svg id="gridIcon" class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 20 20">
                <rect x="2" y="2" width="4.5" height="16" rx="1"/>
                <rect x="7.75" y="2" width="4.5" height="16" rx="1"/>
                <rect x="13.5" y="2" width="4.5" height="16" rx="1"/>
            </svg>
        </button>
        <a href="{{ route('notes.create') }}" class="btn-gold px-6 py-3 rounded-lg transition transform hover:scale-105 flex items-center gap-2">
            <span class="text-xl">+</span> Tambah Catatan
        </a>
    </div>
</div>

<div id="notesGrid" class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @forelse($notes as $note)
        <div class="card-premium p-6 rounded-xl flex flex-col">
            <div class="flex-1">
                <div class="flex items-start justify-between mb-3">
                    <h3 class="text-xl font-bold text-gold flex-1">{{ $note->title }}</h3>

                </div>
                <div class="text-silver mb-4 line-clamp-4 leading-relaxed note-content">{!! Str::limit($note->content, 200) !!}</div>
            </div>
            
            <div class="border-t border-gold pt-4 mt-4">
                <div class="flex items-center gap-2 mb-4 text-sm text-gray-400">
                    <span>{{ $note->created_at->format('d M Y H:i') }}</span>
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('notes.edit', $note) }}" class="flex-1 text-center gradient-gold text-midnight-blue px-4 py-2 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
                        Edit
                    </a>
                    <form action="{{ route('notes.destroy', $note) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full gradient-purple text-white px-4 py-2 rounded-lg hover:opacity-90 transition font-semibold shadow-lg" onclick="return confirm('Yakin ingin menghapus?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-full card-premium rounded-xl p-12">
            <div class="text-center animate-bounce-slow">
                <h3 class="text-2xl font-bold text-gold mb-2">Yah, Masih Kosong!</h3>
                <p class="text-silver mb-6">Belum ada catatan keuangan. Mulai tulis catatan penting pertamamu di sini!</p>
                <a href="{{ route('notes.create') }}" class="inline-block btn-gold px-8 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    Buat Catatan Pertamamu
                </a>
            </div>
        </div>
    @endforelse
</div>

<script>
    let currentLayout = 3; // Default 3 columns
    
    const icons = {
        1: '<rect x="2" y="2" width="16" height="16" rx="2"/>',
        2: '<rect x="2" y="2" width="7" height="16" rx="1"/><rect x="11" y="2" width="7" height="16" rx="1"/>',
        3: '<rect x="2" y="2" width="4.5" height="16" rx="1"/><rect x="7.75" y="2" width="4.5" height="16" rx="1"/><rect x="13.5" y="2" width="4.5" height="16" rx="1"/>'
    };
    
    function toggleGridLayout() {
        // Cycle through layouts: 3 -> 1 -> 2 -> 3
        currentLayout = currentLayout === 3 ? 1 : currentLayout + 1;
        
        const grid = document.getElementById('notesGrid');
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
        localStorage.setItem('notesGridLayout', currentLayout);
    }
    
    // Load saved preference on page load
    document.addEventListener('DOMContentLoaded', function() {
        const savedLayout = localStorage.getItem('notesGridLayout');
        if (savedLayout) {
            currentLayout = parseInt(savedLayout);
            const grid = document.getElementById('notesGrid');
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
