<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Saya | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-amber-500 selection:text-slate-900">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-amber-600/10 rounded-full filter blur-[80px] animate-blob pointer-events-none z-0"></div>

        <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0 border-b border-white/5">
            <h2 class="text-xl font-black text-white flex items-center gap-3">
                <i class="fa-solid fa-receipt text-amber-500"></i> Riwayat Transaksi
            </h2>
            
            <div class="flex items-center gap-6 ml-8">
                <a href="{{ route('customer.wishlist') }}" class="relative text-slate-400 hover:text-rose-400 transition cursor-pointer">
                    <i class="fa-solid fa-heart text-2xl"></i>
                </a>
                <a href="{{ route('customer.cart') }}" class="relative text-slate-400 hover:text-amber-400 transition cursor-pointer">
                    <i class="fa-solid fa-cart-shopping text-2xl"></i>
                </a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10 w-full max-w-[1000px] mx-auto">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Pesanan Anda</h1>
                <p class="text-slate-400 mt-2 text-sm">Pantau status pengiriman dan riwayat belanja sparepart Anda di sini.</p>
            </div>

            <div class="space-y-6">
                @forelse($transactions as $trx)
                    @php
                        // Logika Warna Status
                        $statusColor = match($trx->status) {
                            'pending' => 'slate',
                            'processing' => 'amber',
                            'shipped' => 'indigo',
                            'delivered' => 'emerald',
                            'cancelled' => 'rose',
                            default => 'slate',
                        };
                        
                        $statusText = match($trx->status) {
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Sedang Diproses',
                            'shipped' => 'Dalam Pengiriman',
                            'delivered' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => 'Unknown',
                        };
                    @endphp

                    <div class="glass-card rounded-2xl border border-white/5 overflow-hidden transition-all hover:border-{{$statusColor}}-500/30">
                        <div class="px-6 py-4 border-b border-white/5 bg-slate-800/30 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center gap-4">
                                <i class="fa-solid fa-bag-shopping text-xl text-slate-400"></i>
                                <div>
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">No. Invoice</p>
                                    <p class="text-sm font-bold text-white">{{ $trx->invoice_number }}</p>
                                </div>
                                <div class="hidden md:block w-px h-8 bg-white/10 mx-2"></div>
                                <div class="hidden md:block">
                                    <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Tanggal</p>
                                    <p class="text-sm text-slate-300">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="px-4 py-1.5 rounded-full bg-{{$statusColor}}-500/10 border border-{{$statusColor}}-500/30 text-{{$statusColor}}-400 text-xs font-bold flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-{{$statusColor}}-400 {{ $trx->status == 'processing' ? 'animate-ping' : '' }}"></div>
                                {{ $statusText }}
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            @foreach($trx->details as $detail)
                                <div class="flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center overflow-hidden">
                                            @if($detail->product->image)
                                                <img src="{{ asset('storage/' . $detail->product->image) }}" alt="Produk" class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-gear text-2xl text-slate-600"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-white">{{ $detail->product->name }}</h4>
                                            <p class="text-xs text-slate-400">{{ $detail->qty }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-amber-400">Rp {{ number_format($detail->qty * $detail->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="px-6 py-4 bg-slate-900/50 flex flex-wrap justify-between items-center gap-4 border-t border-white/5">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Total Belanja</p>
                                <p class="text-xl font-black text-white">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <button class="px-6 py-2 rounded-lg bg-amber-500 text-slate-900 font-bold hover:bg-amber-400 transition-colors shadow-[0_0_15px_rgba(245,158,11,0.3)] text-sm">
                                Lihat Detail Nota
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 glass-card rounded-3xl">
                        <i class="fa-solid fa-box-open text-6xl text-slate-700 mb-4"></i>
                        <h2 class="text-xl font-bold text-slate-300">Belum Ada Transaksi</h2>
                        <p class="text-slate-500 mb-6">Anda belum pernah melakukan pembelian.</p>
                        <a href="{{ route('customer.dashboard') }}" class="px-6 py-3 rounded-xl bg-amber-500 text-slate-900 font-bold hover:bg-amber-400 transition-colors">Belanja Sekarang</a>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>