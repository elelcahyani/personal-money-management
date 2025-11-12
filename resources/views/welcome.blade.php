<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dompetku - Kelola Keuangan Anda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .logo-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 py-4">
                <div class="flex justify-between items-center">
                    <div class="font-bold text-2xl logo-text flex items-center gap-2">
                        <span class="text-3xl">💰</span>
                        <span>Dompetku</span>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('login') }}" class="px-6 py-2 text-purple-600 hover:text-purple-700 font-semibold">Login</a>
                        <a href="{{ route('register') }}" class="px-6 py-2 gradient-bg text-white rounded-lg hover:opacity-90 font-semibold">Daftar Gratis</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1 flex items-center">
            <div class="max-w-7xl mx-auto px-4 py-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h1 class="text-5xl font-bold mb-6">
                            Kelola Keuangan Anda dengan <span class="logo-text">Mudah</span>
                        </h1>
                        <p class="text-xl text-gray-600 mb-8">
                            Catat pemasukan & pengeluaran, visualisasikan dengan grafik, dan capai target keuangan Anda.
                        </p>
                        <div class="flex gap-4">
                            <a href="{{ route('register') }}" class="px-8 py-4 gradient-bg text-white rounded-lg hover:opacity-90 font-semibold text-lg">
                                Mulai Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="px-8 py-4 border-2 border-purple-600 text-purple-600 rounded-lg hover:bg-purple-50 font-semibold text-lg">
                                Login
                            </a>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center text-white text-2xl">📊</div>
                                <div>
                                    <h3 class="font-bold text-lg">Grafik Interaktif</h3>
                                    <p class="text-gray-600">Visualisasi transaksi dengan grafik yang mudah dipahami</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center text-white text-2xl">🎯</div>
                                <div>
                                    <h3 class="font-bold text-lg">Target Keuangan</h3>
                                    <p class="text-gray-600">Tetapkan dan lacak progress goals keuangan Anda</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center text-white text-2xl">📥</div>
                                <div>
                                    <h3 class="font-bold text-lg">Export Excel</h3>
                                    <p class="text-gray-600">Download data transaksi untuk analisis lebih lanjut</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 gradient-bg rounded-full flex items-center justify-center text-white text-2xl">📝</div>
                                <div>
                                    <h3 class="font-bold text-lg">Catatan Keuangan</h3>
                                    <p class="text-gray-600">Buat catatan penting terkait keuangan Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t py-6">
            <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
                <p>&copy; {{ date('Y') }} Dompetku. Kelola keuangan Anda dengan mudah.</p>
            </div>
        </footer>
    </div>
</body>
</html>
