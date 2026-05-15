<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Kategori | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #020617; color: white; overflow-x: hidden; }
        .glass-panel { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); transform: translateZ(0); will-change: transform, backdrop-filter; }
        .glass-card { background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); }
        .no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        @keyframes blob {
            0% { transform: translate3d(0px, 0px, 0px) scale(1); }
            33% { transform: translate3d(30px, -50px, 0px) scale(1.1); }
            66% { transform: translate3d(-20px, 20px, 0px) scale(0.9); }
            100% { transform: translate3d(0px, 0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 15s infinite ease-in-out; will-change: transform; backface-visibility: hidden; }
    </style>
</head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-amber-500 selection:text-slate-900">

    <!-- SIDEBAR NAVIGASI UTAMA -->
    @include('layouts.sidebar')

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- DEKORASI ANIMASI BLOBS -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-purple-600/20 rounded-full filter blur-[150px] animate-blob pointer-events-none z-0"></div>

        <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.5)]">
            <h2 class="text-xl font-black text-white flex items-center gap-3">
                <i class="fa-solid fa-layer-group text-amber-500"></i> Jelajahi Kategori
            </h2>
            
            <div class="flex items-center gap-6 ml-8">
                <a href="{{ Auth::check() ? route('customer.wishlist') : route('login') }}" class="relative text-slate-400 hover:text-rose-400 transition cursor-pointer">
                    <i class="fa-solid fa-heart text-2xl"></i>
                </a>
                <a href="{{ Auth::check() ? route('customer.cart') : route('login') }}" class="relative text-slate-400 hover:text-amber-400 transition cursor-pointer">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10 w-full max-w-[1200px] mx-auto">
            
            <nav class="text-xs font-medium text-slate-400 mb-8 flex items-center gap-2">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-amber-400 transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                <span class="text-white font-bold">Semua Kategori</span>
            </nav>

            <div class="mb-10">
                <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Direktori Suku Cadang</h1>
                <p class="text-slate-400 mt-2">Temukan komponen yang tepat untuk ekosistem kendaraanmu di Partlyfe.</p>
            </div>

            <!-- GRID SEMUA KATEGORI (DARK GLASS) -->
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($categories as $cat)
                <a href="{{ route('customer.dashboard', ['category' => $cat->id]) }}" class="glass-card rounded-2xl p-6 flex flex-col items-center justify-center gap-4 hover:shadow-[0_0_20px_rgba(245,158,11,0.15)] hover:border-amber-500/50 hover:-translate-y-1 transition-all duration-300 group cursor-pointer relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-t from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-16 h-16 bg-slate-900/80 border border-white/5 text-slate-500 rounded-2xl flex items-center justify-center text-3xl group-hover:bg-amber-500/20 group-hover:text-amber-400 group-hover:border-amber-500/30 transition-all duration-300 relative z-10">
                        <i class="fa-solid fa-box"></i>
                    </div>
                    <h3 class="font-bold text-slate-300 text-center group-hover:text-white transition relative z-10">{{ $cat->name }}</h3>
                </a>
                @endforeach
            </div>

        </main>
    </div>
</body>
</html>