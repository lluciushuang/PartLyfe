<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #020617; color: white; overflow-x: hidden; }
        .glass-panel { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-bottom: 1px solid rgba(255, 255, 255, 0.05); transform: translateZ(0); will-change: transform, backdrop-filter; }
        .glass-card { background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); }
        .no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        input[type="number"]::-webkit-inner-spin-button, input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
        
        /* Animasi masuk Toast */
        @keyframes slideDownFade {
            0% { opacity: 0; transform: translate(-50%, -20px); }
            100% { opacity: 1; transform: translate(-50%, 0); }
        }
        .toast-enter { animation: slideDownFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    </style>
</head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-amber-500 selection:text-slate-900">


    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <div class="absolute top-20 right-10 w-96 h-96 bg-amber-500/10 rounded-full filter blur-[120px] pointer-events-none z-0"></div>

       <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0 border-b border-white/5">
            <h2 class="text-xl font-black text-white flex items-center gap-3"><i class="fa-solid fa-cart-shopping text-amber-500"></i> Keranjang Belanja</h2>
            
            <div class="flex items-center gap-6 ml-8">
                <a href="{{ Auth::check() ? route('customer.wishlist') : route('login') }}" class="relative text-slate-400 hover:text-rose-400 transition cursor-pointer">
                    <i class="fa-solid fa-heart text-2xl"></i>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10 max-w-[1200px] mx-auto w-full">
            
            @if($cartItems->count() > 0)
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    
                    <!-- KIRI: Daftar Keranjang -->
                    <div class="flex-grow w-full space-y-4">
                        @php $totalBelanja = 0; @endphp

                        @foreach($cartItems as $item)
                            @php 
                                $retailPrice = $item->product->prices->where('price_level', 1)->first()->price ?? 0; 
                                $subtotal = $retailPrice * $item->qty;
                                $totalBelanja += $subtotal;
                            @endphp

                            <div class="glass-card rounded-2xl p-4 flex gap-6 items-center relative group hover:border-white/20 transition-colors shadow-lg">
                                <!-- Hapus Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="absolute top-4 right-4">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-500 hover:text-rose-500 transition hover:scale-110"><i class="fa-solid fa-trash-can"></i></button>
                                </form>

                                <div class="w-24 h-24 bg-slate-900/50 rounded-xl flex items-center justify-center flex-shrink-0 border border-white/5 group-hover:border-amber-500/30 transition-colors">
                                    <i class="fa-solid fa-box-open text-3xl text-slate-600 group-hover:text-amber-500/50 transition-colors"></i>
                                </div>
                                
                                <div class="flex-grow">
                                    <p class="text-[10px] text-amber-500 font-bold uppercase tracking-wider mb-1">{{ $item->product->brand }}</p>
                                    <a href="{{ route('product.detail', $item->product_id) }}" class="font-bold text-lg text-white hover:text-amber-400 transition">{{ $item->product->name }}</a>
                                    <p class="font-black text-white mt-1">Rp {{ number_format($retailPrice, 0, ',', '.') }} <span class="text-xs font-normal text-slate-500">/ pcs</span></p>
                                    
                                    <div class="flex items-center gap-4 mt-4">
                                        <!-- Form Update Qty via JS Auto-Submit -->
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center bg-slate-900/80 border border-white/10 rounded-lg p-1 shadow-inner">
                                            @csrf @method('PATCH')
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepDown(); this.parentNode.submit();" class="w-8 h-8 rounded-md hover:bg-white/10 text-slate-300 font-bold">-</button>
                                            <input type="number" name="qty" value="{{ $item->qty }}" min="1" max="{{ $item->product->current_stock }}" onchange="this.form.submit()" class="w-10 text-center font-bold border-none focus:ring-0 p-0 text-white bg-transparent outline-none">
                                            <button type="button" onclick="this.parentNode.querySelector('input[type=number]').stepUp(); this.parentNode.submit();" class="w-8 h-8 rounded-md hover:bg-white/10 text-amber-400 font-bold">+</button>
                                        </form>
                                        <p class="text-xs text-slate-500">Stok sisa: {{ $item->product->current_stock }}</p>
                                    </div>
                                </div>
                                
                                <div class="text-right flex-shrink-0 mt-auto pt-6">
                                    <p class="text-xs text-slate-400 mb-1">Subtotal Item</p>
                                    <p class="text-xl font-black text-amber-400">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- KANAN: Ringkasan Belanja (Sticky) -->
                    <div class="w-full lg:w-[350px] flex-shrink-0 sticky top-4">
                        <div class="glass-panel rounded-3xl p-6 shadow-2xl border border-white/10">
                            <h3 class="font-bold text-white mb-6 text-lg">Ringkasan Belanja</h3>
                            
                            <div class="space-y-4 mb-6 text-sm">
                                <div class="flex justify-between text-slate-400">
                                    <span>Total Harga ({{ $cartItems->sum('qty') }} barang)</span>
                                    <span class="text-white">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-slate-400">
                                    <span>Diskon Platform</span>
                                    <span class="text-rose-400">- Rp 0</span>
                                </div>
                                <hr class="border-white/5">
                                <div class="flex justify-between items-center pt-2">
                                    <span class="font-bold text-white">Total Tagihan</span>
                                    <span class="text-2xl font-black text-amber-400">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button onclick="alert('Fitur Checkout akan segera hadir!')" class="w-full bg-amber-500 text-slate-900 font-black py-3.5 rounded-xl hover:bg-amber-400 hover:scale-[1.02] transition shadow-[0_0_20px_rgba(245,158,11,0.4)]">
                                Beli Sekarang ({{ $cartItems->sum('qty') }})
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- KONDISI KERANJANG KOSONG -->
                <div class="flex flex-col items-center justify-center h-[60vh] text-center">
                    <i class="fa-solid fa-cart-shopping text-7xl text-slate-700 mb-6"></i>
                    <h2 class="text-2xl font-black text-white mb-2">Keranjangmu masih kosong</h2>
                    <p class="text-slate-400 mb-8">Yuk cari suku cadang incaranmu di katalog kami!</p>
                    <a href="{{ route('customer.dashboard') }}" class="bg-amber-500 text-slate-900 font-bold px-8 py-3 rounded-full hover:bg-amber-400 transition shadow-[0_0_15px_rgba(245,158,11,0.3)]">Mulai Belanja</a>
                </div>
            @endif

        </main>
    </div>
</body>
</html>