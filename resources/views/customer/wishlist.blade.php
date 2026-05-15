<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Saya | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #020617; color: white; overflow-x: hidden; }
        .glass-panel { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); }
        .glass-card { background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); }
        .no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-amber-500 selection:text-slate-900">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-rose-600/10 rounded-full filter blur-[150px] pointer-events-none z-0"></div>

        <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.5)]">
            <h2 class="text-xl font-black text-white flex items-center gap-3">
                <i class="fa-solid fa-heart text-rose-500"></i> Wishlist Tersimpan
            </h2>
        </header>

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10 max-w-[1200px] mx-auto w-full">
            
            @if($wishlists->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($wishlists as $wishlist)
                    @php 
                        $product = $wishlist->product;
                        $isOutofStock = $product->current_stock <= 0; 
                        $retailPrice = $product->prices->where('price_level', 1)->first(); 
                    @endphp

                    <div class="glass-card rounded-2xl hover:shadow-[0_0_25px_rgba(244,63,94,0.15)] hover:border-rose-500/50 transition-all duration-300 group flex flex-col h-full overflow-hidden {{ $isOutofStock ? 'opacity-60' : '' }} relative">
                        
                        <!-- Tombol Hapus dari Wishlist -->
                        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-3 right-3 z-20">
                            @csrf
                            <button type="submit" class="w-8 h-8 bg-slate-900/80 backdrop-blur-sm text-rose-500 rounded-full flex items-center justify-center hover:bg-rose-500 hover:text-white transition shadow-lg border border-white/10">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                            </button>
                        </form>

                        <a href="{{ route('product.detail', $product->id) }}" class="flex-grow flex flex-col cursor-pointer">
                            <div class="h-44 bg-slate-900/60 flex items-center justify-center relative border-b border-white/5">
                                <i class="fa-solid fa-box-open text-5xl text-slate-700 group-hover:scale-110 group-hover:text-rose-500/20 transition-all duration-500"></i>
                                @if($isOutofStock)
                                    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-0">
                                        <span class="bg-slate-800 border border-slate-600 text-white font-black text-xs px-3 py-1 rounded-full uppercase tracking-widest shadow-xl">Stok Habis</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <h3 class="font-medium text-sm text-slate-200 leading-snug line-clamp-2 mb-1 group-hover:text-amber-400 transition">{{ $product->name }}</h3>
                                <p class="font-black text-lg text-white mt-auto pt-2">Rp {{ number_format($retailPrice->price ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </a>

                        <!-- Langsung masuk keranjang -->
                        @if(!$isOutofStock)
                        <div class="p-3 border-t border-white/5 bg-slate-900/30">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-amber-500/10 border border-amber-500/30 text-amber-400 font-bold py-2 rounded-lg hover:bg-amber-500 hover:text-slate-900 transition flex justify-center items-center gap-2 text-xs">
                                    <i class="fa-solid fa-cart-plus"></i> Masukkan Keranjang
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center h-[60vh] text-center">
                    <i class="fa-solid fa-heart-crack text-7xl text-slate-700 mb-6"></i>
                    <h2 class="text-2xl font-black text-white mb-2">Belum ada barang incaran</h2>
                    <p class="text-slate-400 mb-8">Pilih barang kesukaanmu dan simpan di sini untuk dibeli nanti.</p>
                    <a href="{{ route('customer.dashboard') }}" class="bg-amber-500 text-slate-900 font-bold px-8 py-3 rounded-full hover:bg-amber-400 transition shadow-[0_0_15px_rgba(245,158,11,0.3)]">Lihat Katalog</a>
                </div>
            @endif

        </main>
    </div>
</body>
</html>