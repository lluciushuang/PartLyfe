<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabar Admin | Partlyfe</title>
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
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-indigo-500 selection:text-white">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <div class="absolute top-20 right-20 w-[400px] h-[400px] bg-indigo-600/20 rounded-full filter blur-[120px] animate-blob pointer-events-none z-0"></div>
        <div class="absolute bottom-10 left-10 w-[300px] h-[300px] bg-purple-600/20 rounded-full filter blur-[120px] animate-blob animation-delay-2000 pointer-events-none z-0"></div>

        <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.5)]">
            <h2 class="text-xl font-black text-white flex items-center gap-3">
                <i class="fa-solid fa-tower-broadcast text-indigo-400"></i> Pusat Kabar & Notifikasi
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

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10 w-full max-w-[900px] mx-auto">
            
            <div class="flex items-center justify-between mb-8 pb-6 border-b border-white/10">
                <div>
                    <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Pesan dari Admin</h1>
                    <p class="text-slate-400 mt-2 text-sm">Informasi terbaru seputar promo, pesanan, dan pembaruan sistem Partlyfe.</p>
                </div>
                
                @if($broadcasts->where('is_read', false)->count() > 0)
                    <form action="{{ route('customer.broadcast.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-indigo-400 bg-indigo-500/10 border border-indigo-500/30 px-4 py-2 rounded-lg hover:bg-indigo-500 hover:text-white transition-colors flex items-center gap-2 shadow-[0_0_15px_rgba(99,102,241,0.2)]">
                            <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
                        </button>
                    </form>
                @endif
            </div>

            <div class="space-y-4">
                @forelse($broadcasts as $bc)
                    @php
                        if($bc->type == 'promo') {
                            $color = 'amber'; $icon = 'fa-bullhorn'; $label = 'Promo Spesial';
                        } elseif($bc->type == 'system') {
                            $color = 'indigo'; $icon = 'fa-robot'; $label = 'Update Sistem';
                        } else {
                            $color = 'slate'; $icon = 'fa-circle-info'; $label = 'Informasi Umum';
                        }
                    @endphp

                    <div @if(!$bc->is_read) onclick="document.getElementById('read-form-{{$bc->id}}').submit();" @endif 
                         class="glass-card rounded-2xl p-6 flex gap-6 items-start relative group transition-all duration-300 {{ !$bc->is_read ? 'hover:border-'.$color.'-500/50 hover:shadow-[0_0_20px_rgba(255,255,255,0.05)] cursor-pointer' : 'opacity-60 grayscale-[30%]' }} overflow-hidden">
                        
                        @if(!$bc->is_read)
                            <form id="read-form-{{$bc->id}}" action="{{ route('customer.broadcast.read', $bc->id) }}" method="POST" class="hidden">
                                @csrf
                            </form>
                            
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-{{$color}}-500 shadow-[0_0_10px_currentColor]"></div>
                        @endif
                        
                        <div class="w-14 h-14 bg-{{$color}}-500/10 border border-{{$color}}-500/20 text-{{$color}}-400 rounded-xl flex items-center justify-center flex-shrink-0 {{ !$bc->is_read ? 'group-hover:scale-110' : '' }} transition-transform">
                            <i class="fa-solid {{ $icon }} text-2xl"></i>
                        </div>
                        
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-lg font-bold {{ $bc->is_read ? 'text-slate-400' : 'text-white' }} {{ !$bc->is_read ? 'group-hover:text-'.$color.'-400' : '' }} transition-colors">{{ $bc->title }}</h3>
                                <span class="text-xs text-slate-500 font-medium">{{ $bc->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-400 text-sm leading-relaxed mb-3">{{ $bc->message }}</p>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest flex items-center gap-1">
                                <i class="fa-solid fa-tag"></i> {{ $label }}
                            </span>
                        </div>
                        
                        @if(!$bc->is_read)
                            <div class="absolute top-6 right-6 w-2.5 h-2.5 rounded-full bg-rose-500 shadow-[0_0_10px_rgba(225,29,72,0.8)] animate-pulse"></div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-20">
                        <i class="fa-solid fa-envelope-open text-6xl text-slate-700 mb-4"></i>
                        <h2 class="text-xl font-bold text-slate-300">Belum Ada Pesan</h2>
                        <p class="text-slate-500">Kotak masukmu masih kosong bersih.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>