<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Partlyfe | Ekosistem Suku Cadang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>.no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }</style>
</head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-amber-500 selection:text-slate-900">

    <!-- SIDEBAR -->
    @include('layouts.sidebar')

    <!-- KONTEN UTAMA (DARK MODE) -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <!-- DEKORASI ANIMASI BLOBS DI BACKGROUND (Optimized) -->
        <div class="absolute top-20 left-10 w-96 h-96 bg-indigo-600/30 rounded-full filter blur-[100px] animate-blob pointer-events-none z-0"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-amber-500/20 rounded-full filter blur-[100px] animate-blob animation-delay-2000 pointer-events-none z-0"></div>
        <!-- Header Atas (Kaca) -->
        <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0">
            <form action="{{ route('customer.dashboard') }}" method="GET" class="relative w-full max-w-3xl">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari V-belt, Oli Mesin, Kampas Rem di Partlyfe..." class="w-full bg-slate-900/50 border border-white/10 rounded-xl py-2.5 pl-12 pr-6 focus:bg-slate-800 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all font-medium text-sm text-white placeholder-slate-500 shadow-inner">
                <button type="submit" class="absolute left-4 top-3 text-slate-400 hover:text-amber-500 transition-colors">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
            
            <div class="flex items-center gap-6 ml-8">
                <a href="{{ Auth::check() ? route('customer.wishlist') : route('login') }}" class="relative text-slate-400 hover:text-rose-400 transition cursor-pointer">
                    <i class="fa-solid fa-heart text-2xl"></i>
                    @auth 
                        @php $wishlistCount = \App\Models\Wishlist::where('user_id', Auth::id())->count(); @endphp
                        @if($wishlistCount > 0)
                            <span class="absolute -top-1 -right-2 bg-rose-500 text-white text-[10px] font-bold px-1.5 rounded-full shadow-[0_0_10px_rgba(244,63,94,0.6)]">{{ $wishlistCount }}</span> 
                        @endif
                    @endauth
                </a>
                <a href="{{ Auth::check() ? route('customer.cart') : route('login') }}" class="relative text-slate-400 hover:text-amber-400 transition cursor-pointer">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                    @auth 
                        @php $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('qty'); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-2 bg-amber-500 text-slate-900 text-[10px] font-black px-1.5 rounded-full shadow-[0_0_10px_rgba(245,158,11,0.6)]">{{ $cartCount }}</span> 
                        @endif
                    @endauth
                </a>
            </div>
        </header>

        <!-- Area Scrollable -->
        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10">
            
            <!-- BANNER PROMO -->
            <div class="bg-gradient-to-r from-indigo-900 via-purple-900 to-rose-900 rounded-3xl p-8 mb-8 text-white shadow-2xl relative overflow-hidden flex items-center justify-between border border-white/10">
                <div class="relative z-10 max-w-xl">
                    <span class="bg-black/40 backdrop-blur-md px-3 py-1 rounded-full text-xs font-black tracking-wider uppercase mb-4 inline-block border border-white/20 text-amber-400 shadow-sm">
                        <i class="fa-solid fa-bolt mr-1"></i> Partlyfe Mega Deals
                    </span>
                    <h2 class="text-4xl font-black mb-3 leading-tight text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">Revolusi Harga Suku Cadang</h2>
                    <p class="text-indigo-200 mb-6 text-sm leading-relaxed">Nikmati pengalaman belanja suku cadang modern. Klaim voucher gratis ongkir dan diskon hingga 30% khusus untuk transaksi di aplikasi Partlyfe hari ini!</p>
                    <button class="bg-amber-500 text-slate-900 font-black px-8 py-3 rounded-xl hover:bg-amber-400 transition shadow-[0_0_20px_rgba(245,158,11,0.4)] transform hover:-translate-y-1">
                        Klaim Promo Sekarang
                    </button>
                </div>
                <i class="fa-solid fa-motorcycle text-[250px] opacity-10 absolute -right-10 -bottom-16 transform -rotate-12 mix-blend-overlay"></i>
                <div class="absolute top-0 right-1/3 w-32 h-full bg-white/5 transform skew-x-12"></div>
            </div>

            <!-- KATEGORI SHORTCUT (DARK GLASS) -->
            <div class="glass-card rounded-3xl p-6 shadow-lg mb-8 relative z-20">
                <h3 class="font-black text-white mb-5 text-lg">Kategori Pilihan</h3>
                <div class="flex gap-4 overflow-x-auto no-scrollbar snap-x pb-2">
                    @foreach($categories->take(8) as $cat)
                    <a href="{{ route('customer.dashboard', ['category' => $cat->id]) }}" class="snap-start flex-shrink-0 group flex flex-col items-center gap-3 w-24 cursor-pointer">
                        <div class="w-16 h-16 bg-slate-800/50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-amber-500 group-hover:text-slate-900 transition shadow-sm border border-white/5 group-hover:border-amber-400 group-hover:-translate-y-1 group-hover:shadow-[0_0_15px_rgba(245,158,11,0.3)]">
                            <i class="fa-solid fa-layer-group text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-400 group-hover:text-amber-400 text-center truncate w-full px-1">{{ $cat->name }}</span>
                    </a>
                    @endforeach

                    <!-- Lihat Semua -->
                    <a href="{{ route('customer.categories') }}" class="snap-start flex-shrink-0 group flex flex-col items-center gap-3 w-24 cursor-pointer">
                        <div class="w-16 h-16 bg-white/5 rounded-2xl flex items-center justify-center text-white group-hover:bg-white/20 transition shadow-sm border border-white/10 group-hover:-translate-y-1">
                            <i class="fa-solid fa-arrow-right text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-300 text-center w-full">Lihat Semua</span>
                    </a>
                </div>
            </div>

            <!-- HEADER ETALASE & FILTER -->
            <div class="flex items-center justify-between mb-6 sticky -top-8 -mx-8 px-8 pt-10 pb-4 glass-panel z-40 shadow-[0_10px_30px_-10px_rgba(0,0,0,0.5)]">
                <h2 class="text-2xl font-black text-white flex items-center gap-2">Etalase Suku Cadang</h2>
                <form action="{{ route('customer.dashboard') }}" method="GET" id="sort-form" class="flex items-center gap-3">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    <select name="sort" onchange="this.form.submit()" class="bg-slate-900/80 border border-white/10 py-2.5 pl-4 pr-10 rounded-xl text-sm font-bold text-slate-300 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 shadow-sm cursor-pointer hover:border-white/30 transition-colors">
                        <option value="relevansi" {{ request('sort') == 'relevansi' ? 'selected' : '' }}>Urutkan: Relevansi</option>
                        <option value="terendah" {{ request('sort') == 'terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="tertinggi" {{ request('sort') == 'tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            <!-- GRID PRODUK (DARK GLASS CARD) -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                @foreach($products as $product)
                @php $isOutofStock = ($loop->iteration % 5 == 0) || $product->current_stock <= 0; @endphp

                <div class="glass-card rounded-2xl hover:shadow-[0_0_25px_rgba(245,158,11,0.15)] hover:border-amber-500/50 transition-all duration-300 group flex flex-col h-full overflow-hidden {{ $isOutofStock ? 'opacity-60 grayscale-[50%]' : '' }} relative">
                    <a href="{{ route('product.detail', $product->id) }}" class="flex-grow flex flex-col cursor-pointer">
                        <div class="h-44 bg-slate-900/60 flex items-center justify-center relative overflow-hidden border-b border-white/5">
                            <div class="absolute top-2 left-2 bg-rose-500/90 backdrop-blur-sm text-white text-[10px] font-black px-2 py-1 rounded-md z-10 border border-rose-400/50 shadow-[0_0_10px_rgba(225,29,72,0.5)]">Cashback 5%</div>
                            <i class="fa-solid fa-box-open text-5xl text-slate-700 group-hover:scale-110 group-hover:text-amber-500/20 transition-all duration-500"></i>
                            @if($isOutofStock)
                                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-0">
                                    <span class="bg-slate-800 border border-slate-600 text-white font-black text-xs px-3 py-1 rounded-full uppercase tracking-widest shadow-xl">Stok Habis</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-medium text-sm text-slate-200 leading-snug line-clamp-2 mb-1 group-hover:text-amber-400 transition">{{ $product->name }}</h3>
                            @php $retailPrice = $product->prices->where('price_level', 1)->first(); @endphp
                            <p class="font-black text-lg text-white mb-2">Rp {{ number_format($retailPrice->price ?? 0, 0, ',', '.') }}</p>
                            
                            <div class="flex items-center gap-1.5 text-[10px] text-slate-400 mb-3 font-medium">
                                <i class="fa-solid fa-circle-check text-blue-400 text-[11px]"></i>
                                <span class="truncate font-bold">Partlyfe Official</span>
                            </div>
                            <div class="flex items-center gap-2 text-[10px] text-slate-500 mt-auto pt-3 border-t border-white/5">
                                <span class="flex items-center gap-0.5 text-amber-400 font-bold"><i class="fa-solid fa-star"></i> 4.9</span>
                                <span>|</span><span>Terjual 1rb+</span>
                            </div>
                        </div>
                    </a>

                    <!-- Tombol Keranjang Hover -->
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0">
                        @if(!$isOutofStock)
                            @auth
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-9 h-9 bg-amber-500 text-slate-900 font-black rounded-full flex items-center justify-center hover:bg-amber-400 shadow-[0_0_15px_rgba(245,158,11,0.5)] hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-plus text-sm"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="w-9 h-9 bg-amber-500 text-slate-900 font-black rounded-full flex items-center justify-center hover:bg-amber-400 shadow-[0_0_15px_rgba(245,158,11,0.5)] hover:scale-110 transition-transform">
                                    <i class="fa-solid fa-plus text-sm"></i>
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Paginasi -->
            <div class="mt-10 pb-10 w-full">
                {{ $products->links('components.pagination') }}
            </div>
        </main>
    </div>
</body>
</html>