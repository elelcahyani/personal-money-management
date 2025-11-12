@extends('layouts.app')

@section('title', 'Edit Catatan')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gold mb-2">Edit Catatan</h1>
        <p class="text-silver">Perbarui catatan keuanganmu</p>
    </div>

    <div class="card-premium p-8 rounded-xl">
        <form method="POST" action="{{ route('notes.update', $note) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Judul Catatan</label>
                <input type="text" name="title" value="{{ old('title', $note->title) }}" 
                    class="w-full px-4 py-3 bg-dark-gray border border-gold text-silver rounded-lg focus:outline-none focus:ring-2 focus:ring-gold transition" required>
                @error('title')
                    <p class="text-purple-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label class="block text-gold font-semibold mb-2 uppercase tracking-wide text-sm">Konten</label>
                
                <!-- Toolbar -->
                <div class="bg-dark-gray border border-gold rounded-t-lg p-2 flex items-center gap-1 flex-wrap">
                    <!-- Font Size -->
                    <select id="fontSize" class="bg-hover text-silver px-2 py-1 rounded text-sm border border-gold focus:outline-none focus:ring-1 focus:ring-gold">
                        <option value="12">12</option>
                        <option value="14">14</option>
                        <option value="16" selected>16</option>
                        <option value="18">18</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                    </select>
                    
                    <div class="w-px h-6 bg-gold mx-1"></div>
                    
                    <!-- Bold -->
                    <button type="button" onclick="formatText('bold')" class="toolbar-btn px-3 py-1 bg-hover hover:bg-gold hover:text-midnight-blue rounded transition" title="Bold (Ctrl+B)">
                        <span class="font-bold text-lg">B</span>
                    </button>
                    
                    <!-- Italic -->
                    <button type="button" onclick="formatText('italic')" class="toolbar-btn px-3 py-1 bg-hover hover:bg-gold hover:text-midnight-blue rounded transition" title="Italic (Ctrl+I)">
                        <span class="italic text-lg">I</span>
                    </button>
                    
                    <!-- Underline -->
                    <button type="button" onclick="formatText('underline')" class="toolbar-btn px-3 py-1 bg-hover hover:bg-gold hover:text-midnight-blue rounded transition" title="Underline (Ctrl+U)">
                        <span class="underline text-lg">U</span>
                    </button>
                    
                    <!-- Strikethrough -->
                    <button type="button" onclick="formatText('strikethrough')" class="toolbar-btn px-3 py-1 bg-hover hover:bg-gold hover:text-midnight-blue rounded transition" title="Strikethrough">
                        <span class="line-through text-lg">S</span>
                    </button>
                    
                    <div class="w-px h-6 bg-gold mx-1"></div>
                    
                    <!-- Bullet List -->
                    <button type="button" onclick="insertList('bullet')" class="toolbar-btn px-3 py-1 bg-hover hover:bg-gold hover:text-midnight-blue rounded transition" title="Bullet List">
                        <span class="text-lg">•</span>
                    </button>
                    
                    <!-- Numbered List -->
                    <button type="button" onclick="insertList('number')" class="toolbar-btn px-3 py-1 bg-hover hover:bg-gold hover:text-midnight-blue rounded transition" title="Numbered List">
                        <span class="text-lg">#</span>
                    </button>
                </div>
                
                <div id="noteContent" contenteditable="true"
                    class="w-full px-4 py-3 bg-dark-gray border border-gold border-t-0 text-silver rounded-b-lg focus:outline-none focus:ring-2 focus:ring-gold transition leading-relaxed min-h-[300px] max-h-[500px] overflow-y-auto">{!! old('content', $note->content) !!}</div>
                <input type="hidden" name="content" id="contentInput" required>
                @error('content')
                    <p class="text-purple-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <style>
                .toolbar-btn {
                    color: #EFEFEF;
                }
                .toolbar-btn:hover {
                    transform: scale(1.05);
                }
                #noteContent b, #noteContent strong {
                    font-weight: bold;
                }
                #noteContent i, #noteContent em {
                    font-style: italic;
                }
                #noteContent u {
                    text-decoration: underline;
                }
                #noteContent strike, #noteContent s {
                    text-decoration: line-through;
                }
                #noteContent ul {
                    list-style-type: disc;
                    margin-left: 20px;
                    padding-left: 10px;
                }
                #noteContent ol {
                    list-style-type: decimal;
                    margin-left: 20px;
                    padding-left: 10px;
                }
                #noteContent li {
                    margin: 5px 0;
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const editor = document.getElementById('noteContent');
                    const contentInput = document.getElementById('contentInput');
                    const fontSizeSelect = document.getElementById('fontSize');

                    // Format text using execCommand
                    window.formatText = function(format) {
                        editor.focus();
                        
                        try {
                            switch(format) {
                                case 'bold':
                                    document.execCommand('bold', false, null);
                                    break;
                                case 'italic':
                                    document.execCommand('italic', false, null);
                                    break;
                                case 'underline':
                                    document.execCommand('underline', false, null);
                                    break;
                                case 'strikethrough':
                                    document.execCommand('strikeThrough', false, null);
                                    break;
                            }
                        } catch(e) {
                            console.error('Format error:', e);
                        }
                    };

                    // Insert list
                    window.insertList = function(type) {
                        editor.focus();
                        
                        try {
                            if (type === 'bullet') {
                                document.execCommand('insertUnorderedList', false, null);
                            } else {
                                document.execCommand('insertOrderedList', false, null);
                            }
                        } catch(e) {
                            console.error('List error:', e);
                        }
                    };

                    // Clear format
                    window.clearFormat = function() {
                        editor.focus();
                        
                        try {
                            document.execCommand('removeFormat', false, null);
                        } catch(e) {
                            console.error('Clear format error:', e);
                        }
                    };

                    // Keyboard shortcuts
                    editor.addEventListener('keydown', function(e) {
                        if (e.ctrlKey || e.metaKey) {
                            switch(e.key.toLowerCase()) {
                                case 'b':
                                    e.preventDefault();
                                    formatText('bold');
                                    break;
                                case 'i':
                                    e.preventDefault();
                                    formatText('italic');
                                    break;
                                case 'u':
                                    e.preventDefault();
                                    formatText('underline');
                                    break;
                            }
                        }
                    });

                    // Font size change
                    fontSizeSelect.addEventListener('change', function() {
                        editor.style.fontSize = this.value + 'px';
                    });

                    // Set initial content to hidden input
                    contentInput.value = editor.innerHTML;

                    // Update hidden input on content change
                    editor.addEventListener('input', function() {
                        contentInput.value = editor.innerHTML;
                    });

                    // Save content to hidden input before submit
                    document.querySelector('form').addEventListener('submit', function(e) {
                        const content = editor.innerHTML.trim();
                        const textContent = editor.textContent.trim();
                        
                        contentInput.value = content;
                        
                        if (textContent === '' || content === '' || content === '<br>') {
                            e.preventDefault();
                            alert('Konten tidak boleh kosong');
                            return false;
                        }
                    });
                });
            </script>

            <div class="flex gap-4">
                <button type="submit" class="flex-1 btn-gold px-6 py-3 rounded-lg font-semibold shadow-lg transform hover:scale-105 transition">
                    Update Catatan
                </button>
                <a href="{{ route('notes.index') }}" class="flex-1 text-center gradient-purple text-white px-6 py-3 rounded-lg hover:opacity-90 transition font-semibold shadow-lg">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
