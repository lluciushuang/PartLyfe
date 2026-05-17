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
            
            <div class="mb-6">
                <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Pesanan Anda</h1>
                <p class="text-slate-400 mt-2 text-sm">Pantau status pengiriman dan riwayat belanja sparepart Anda di sini.</p>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-3 mb-8 border-b border-white/5 no-scrollbar flex-shrink-0">
                <button onclick="filterStatus('all', this)" class="filter-btn active-tab px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-amber-500 text-slate-900 shadow-[0_0_15px_rgba(245,158,11,0.2)]">Semua</button>
                <button onclick="filterStatus('pending', this)" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-slate-900/50 text-slate-400 border border-white/5 hover:text-white hover:bg-slate-800">Menunggu Pembayaran</button>
                <button onclick="filterStatus('processing', this)" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-slate-900/50 text-slate-400 border border-white/5 hover:text-white hover:bg-slate-800">Sedang Diproses</button>
                <button onclick="filterStatus('shipped', this)" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-slate-900/50 text-slate-400 border border-white/5 hover:text-white hover:bg-slate-800">Dalam Pengiriman</button>
                <button onclick="filterStatus('delivered', this)" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-slate-900/50 text-slate-400 border border-white/5 hover:text-white hover:bg-slate-800">Selesai</button>
                <button onclick="filterStatus('cancelled', this)" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-slate-900/50 text-slate-400 border border-white/5 hover:text-white hover:bg-slate-800">Dibatalkan</button>
            </div>

            <div id="transactions-wrapper" class="space-y-6">
                @forelse($transactions as $trx)
                    @php
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

                    <div class="transaction-card glass-card rounded-2xl border border-white/5 overflow-hidden transition-all duration-300 hover:border-{{$statusColor}}-500/30" data-status="{{ $trx->status }}">
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
                                    <p class="text-sm text-slate-300">{{ $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
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
                            <a href="{{ route('customer.invoice', $trx->invoice_number) }}" class="px-6 py-2 rounded-lg bg-amber-500 text-slate-900 font-bold hover:bg-amber-400 transition-colors shadow-[0_0_15px_rgba(245,158,11,0.3)] text-sm inline-block">
                                Lihat Detail Nota
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 glass-card rounded-3xl" id="no-trx-fallback">
                        <i class="fa-solid fa-box-open text-6xl text-slate-700 mb-4"></i>
                        <h2 class="text-xl font-bold text-slate-300">Belum Ada Transaksi</h2>
                        <p class="text-slate-500 mb-6">Anda belum pernah melakukan pembelian.</p>
                        <a href="{{ route('customer.dashboard') }}" class="px-6 py-3 rounded-xl bg-amber-500 text-slate-900 font-bold hover:bg-amber-400 transition-colors">Belanja Sekarang</a>
                    </div>
                @endforelse

                <div id="filter-empty-state" class="text-center py-20 glass-card rounded-3xl hidden">
                    <i class="fa-solid fa-filter-circle-xmark text-6xl text-slate-700 mb-4"></i>
                    <h2 class="text-xl font-bold text-slate-300">Tidak Menemukan Transaksi</h2>
                    <p class="text-slate-500">Tidak ada pesanan Anda yang berstatus demikian.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        function filterStatus(status, element) {
            // 1. Reset Semua Style Button Filter ke Mode Non-Aktif
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => {
                btn.className = "filter-btn px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-slate-900/50 text-slate-400 border border-white/5 hover:text-white hover:bg-slate-800";
            });

            // 2. Set Button yang Sedang Diklik Menjadi Aktif (Warna Amber Glow)
            element.className = "filter-btn active-tab px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all bg-amber-500 text-slate-900 shadow-[0_0_15px_rgba(245,158,11,0.2)]";

            // 3. Lakukan Proses Penyaringan Card
            const cards = document.querySelectorAll('.transaction-card');
            const fallbackZero = document.getElementById('filter-empty-state');
            const defaultFallback = document.getElementById('no-trx-fallback');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                
                if (status === 'all' || cardStatus === status) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // 4. Munculkan State Kosong Khusus jika Filter Menghasilkan 0 Data
            if (cards.length > 0) {
                if (visibleCount === 0) {
                    fallbackZero.classList.remove('hidden');
                } else {
                    fallbackZero.classList.add('hidden');
                }
            }
        }
    </script>
</body>
</html>