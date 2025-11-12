<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dompetku - Aplikasi manajemen keuangan pribadi untuk mengelola pemasukan, pengeluaran, dan target keuangan Anda">
    <meta name="author" content="Dompetku">
    <title>@yield('title', 'Dompetku') - Kelola Keuangan Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Premium Dark Theme Colors */
        :root {
            --midnight-blue: #12121B;
            --dark-gray: #2D2D3A;
            --gold: #FFD700;
            --purple-accent: #9B59B6;
            --silver: #EFEFEF;
            --card-bg: #1E1E2E;
            --hover-bg: #252535;
            --input-text: #8B8B9A;
        }

        body {
            background: linear-gradient(135deg, #12121B 0%, #1E1E2E 100%);
            color: #EFEFEF;
        }

        /* Input text color - darker for better contrast */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        select,
        textarea {
            color: #8B8B9A !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            color: #A0A0B0 !important;
        }

        .logo-text {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-gold {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
        }

        .gradient-purple {
            background: linear-gradient(135deg, #9B59B6 0%, #8E44AD 100%);
        }

        .card-premium {
            background: var(--card-bg);
            border: 1px solid rgba(255, 215, 0, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .card-premium:hover {
            border-color: rgba(255, 215, 0, 0.3);
            box-shadow: 0 12px 48px rgba(255, 215, 0, 0.1);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .btn-gold {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: #12121B;
            font-weight: 600;
            box-shadow: 0 4px 16px rgba(255, 215, 0, 0.3);
        }

        .btn-gold:hover {
            box-shadow: 0 6px 24px rgba(255, 215, 0, 0.5);
            transform: translateY(-2px);
        }

        .text-gold {
            color: #FFD700;
        }

        .text-silver {
            color: #EFEFEF;
        }

        .border-gold {
            border-color: rgba(255, 215, 0, 0.3);
        }

        .bg-dark-card {
            background: var(--card-bg);
        }

        .bg-hover {
            background: var(--hover-bg);
        }
        
        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        .animate-bounce-slow {
            animation: bounce-slow 2s ease-in-out infinite;
        }
        
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .mobile-menu {
            animation: slideDown 0.3s ease-out;
        }

        .hamburger-line {
            transition: all 0.3s ease-in-out;
            background: #FFD700 !important;
        }
        
        .hamburger-active .line-1 {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .hamburger-active .line-2 {
            opacity: 0;
        }
        
        .hamburger-active .line-3 {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #12121B;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #FFD700;
        }
    </style>
</head>
<body class="bg-gray-100">
    @auth
    <nav class="bg-dark-card shadow-2xl sticky top-0 z-50 border-b border-gold">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="font-bold text-2xl logo-text flex items-center gap-2">
                    <span>Dompetku</span>
                </a>

                <!-- Desktop Menu (Centered) -->
                <div class="hidden md:flex items-center space-x-1 absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-hover transition {{ request()->routeIs('dashboard') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-2 rounded-lg hover:bg-hover transition {{ request()->routeIs('transactions.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Transaksi
                    </a>
                    <a href="{{ route('goals.index') }}" class="px-4 py-2 rounded-lg hover:bg-hover transition {{ request()->routeIs('goals.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Goals
                    </a>
                    <a href="{{ route('notes.index') }}" class="px-4 py-2 rounded-lg hover:bg-hover transition {{ request()->routeIs('notes.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Catatan
                    </a>
                </div>

                <!-- Desktop Right Menu -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('profile.index') }}" class="px-4 py-2 rounded-lg hover:bg-hover {{ request()->routeIs('profile.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }} transition">
                        Profile
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-hover transition">
                    <div class="w-6 h-5 flex flex-col justify-between">
                        <span class="hamburger-line line-1 w-full h-0.5 rounded"></span>
                        <span class="hamburger-line line-2 w-full h-0.5 rounded"></span>
                        <span class="hamburger-line line-3 w-full h-0.5 rounded"></span>
                    </div>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 mobile-menu">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('dashboard') }}" class="px-4 py-3 rounded-lg hover:bg-hover transition {{ request()->routeIs('dashboard') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('transactions.index') }}" class="px-4 py-3 rounded-lg hover:bg-hover transition {{ request()->routeIs('transactions.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Transaksi
                    </a>
                    <a href="{{ route('goals.index') }}" class="px-4 py-3 rounded-lg hover:bg-hover transition {{ request()->routeIs('goals.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Goals
                    </a>
                    <a href="{{ route('notes.index') }}" class="px-4 py-3 rounded-lg hover:bg-hover transition {{ request()->routeIs('notes.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }}">
                        Catatan
                    </a>
                    <hr class="my-2 border-gold">
                    <a href="{{ route('profile.index') }}" class="px-4 py-3 rounded-lg hover:bg-hover {{ request()->routeIs('profile.*') ? 'bg-hover text-gold font-semibold' : 'text-silver' }} transition">
                        Profile
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                this.classList.toggle('hamburger-active');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const isClickInside = mobileMenuButton.contains(event.target) || mobileMenu.contains(event.target);
                if (!isClickInside && !mobileMenu.classList.contains('hidden')) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.classList.remove('hamburger-active');
                }
            });

            // Close mobile menu when window is resized to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 768) {
                    mobileMenu.classList.add('hidden');
                    mobileMenuButton.classList.remove('hamburger-active');
                }
            });
        }
    </script>
    @endauth

    <main class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="card-premium border-gold px-4 py-3 rounded-lg mb-4 animate-fade-in">
                <div class="flex items-center gap-2">
                    <span class="text-gold font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
