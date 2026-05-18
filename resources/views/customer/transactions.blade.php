<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Riwayat Transaksi | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        .glass-header { 
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); 
            border-b: 1px solid rgba(226, 232, 240, 0.8); 
        }
        .luxury-card-flat {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: 0 4px 20px rgba(148, 163, 184, 0.04);
            transition: transform 0.2s;
        }
        .luxury-card-flat:hover {
            transform: translateY(-2px);
        }

        /* TOKOPEDIA FILTER TAB STYLE */
        .filter-tab {
            padding: 8px 16px; border-radius: 8px; border: 1px solid #e5e7eb;
            background: #ffffff; font-size: 12px; font-weight: 600; color: #4b5563;
            transition: all 0.2s ease; white-space: nowrap;
        }
        .filter-tab:hover { border-color: #d1d5db; background: #f9fafb; }
        .filter-tab-active {
            background: #fffbeb !important; border-color: #f59e0b !important; color: #d97706 !important; font-weight: 700;
        }
    </style>
</head>

<body class="bg-[#f8fafc] font-sans text-slate-700 h-screen overflow-hidden flex">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        {{-- Header --}}
        <header class="h-20 glass-header flex items-center justify-between px-8 flex-shrink-0 z-50">
            <div class="text-sm font-bold text-slate-400">
                <a href="{{ route('customer.dashboard') }}" class="hover:text-amber-600 transition-colors">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[8px] mx-1 opacity-40"></i>
                <span class="text-slate-700">Riwayat Transaksi</span>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('customer.profile') }}" class="w-9 h-9 bg-gradient-to-br from-amber-400 to-amber-500 text-slate-900 rounded-full flex items-center justify-center font-black text-sm" style="box-shadow: 0 4px 12px rgba(245,158,11,0.2);">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </a>
            </div>
        </header>

        {{-- Main Content Area --}}
        <main class="flex-1 overflow-y-auto p-8 bg-[#f8fafc]">
            <div class="max-w-[1000px] mx-auto">
                <h1 class="text-2xl font-black text-slate-800 mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-receipt text-amber-500"></i> Daftar Transaksi Anda
                </h1>

                {{-- 🚀 BARU: TOKOPEDIA HORIZONTAL FILTER TABS --}}
                <div class="mb-6 flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                    <a href="{{ route('customer.transactions') }}" class="filter-tab {{ !$statusFilter ? 'filter-tab-active' : '' }}">
                        Semua Transaksi
                    </a>
                    <a href="{{ route('customer.transactions', ['status' => 'menunggu']) }}" class="filter-tab {{ $statusFilter == 'menunggu' ? 'filter-tab-active' : '' }}">
                        Menunggu Pembayaran
                    </a>
                    <a href="{{ route('customer.transactions', ['status' => 'diproses']) }}" class="filter-tab {{ $statusFilter == 'diproses' ? 'filter-tab-active' : '' }}">
                        Sedang Diproses
                    </a>
                    <a href="{{ route('customer.transactions', ['status' => 'dikirim']) }}" class="filter-tab {{ $statusFilter == 'dikirim' ? 'filter-tab-active' : '' }}">
                        Sedang Dikirim
                    </a>
                    <a href="{{ route('customer.transactions', ['status' => 'gagal']) }}" class="filter-tab {{ $statusFilter == 'gagal' ? 'filter-tab-active' : '' }}">
                        Gagal / Batal
                    </a>
                </div>

                @if(isset($transactions) && $transactions->count() > 0)
                    <div class="space-y-4">
                        @foreach($transactions as $trx)
                        <div class="luxury-card-flat rounded-2xl p-6 bg-white">
                            
                            {{-- Header Nota Transaksi --}}
                            <div class="flex flex-wrap items-center justify-between gap-4 pb-4 border-b border-slate-100 mb-4 text-xs text-slate-400 font-bold uppercase tracking-wider">
                                <div class="flex items-center gap-4">
                                    <span class="text-slate-700 font-mono">INV-{{ $trx->invoice_number ?? $trx->id }}</span>
                                    <span>•</span>
                                    <span>{{ $trx->created_at->format('d M Y - H:i') }}</span>
                                </div>
                                
                                {{-- Rendering Status Badge Terkalibrasi --}}
                                @php 
                                    $status = strtolower($trx->status ?? $trx->payment_status ?? ''); 
                                @endphp

                                @if($status === 'processing')
                                    <span class="px-2.5 py-1 rounded bg-emerald-50 border border-emerald-200 text-emerald-600">Sedang Diproses</span>
                                @elseif($status === 'dikirim')
                                    <span class="px-2.5 py-1 rounded bg-blue-50 border border-blue-200 text-blue-600 animate-pulse">Kurir Sedang Mengirim</span>
                                @elseif(in_array($status, ['settlement', 'capture', 'success', 'paid', 'lunas', 'berhasil']))
                                    <span class="px-2.5 py-1 rounded bg-emerald-50 border border-emerald-200 text-emerald-600">Selesai</span>
                                @elseif(in_array($status, ['pending', 'unpaid', 'menunggu']))
                                    <span class="px-2.5 py-1 rounded bg-amber-50 border border-amber-200 text-amber-600 animate-pulse">Menunggu Pembayaran</span>
                                @else
                                    <span class="px-2.5 py-1 rounded bg-rose-50 border border-rose-200 text-rose-600">Gagal / Dibatalkan</span>
                                @endif
                            </div>

                            {{-- Info Barang --}}
                            <div class="flex items-start justify-between gap-6">
                                <div class="flex items-start gap-4">
                                    <div class="w-14 h-14 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center flex-shrink-0 text-slate-300 overflow-hidden p-1">
                                        @if($trx->details && $trx->details->isNotEmpty() && $trx->details->first()->product && $trx->details->first()->product->images->isNotEmpty())
                                            <img src="{{ asset('storage/products/' . basename($trx->details->first()->product->images->first()->image_path)) }}" class="w-full h-full object-contain">
                                        @else
                                            <i class="fa-solid fa-box text-2xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black text-slate-800 leading-snug mb-1">
                                            {{ $trx->details->first()->product->name ?? 'Suku Cadang Partlyfe' }}
                                        </h4>
                                        <p class="text-xs text-slate-400">
                                            @if($trx->details && $trx->details->count() > 1)
                                                + {{ $trx->details->count() - 1 }} produk lainnya
                                            @else
                                                Total Pembayaran Terhitung
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Total Nominal Pembayaran & Action Buttons --}}
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs text-slate-400 font-bold mb-0.5">Total Belanja</p>
                                    <p class="text-base font-black text-slate-900 mb-3">
                                        Rp {{ number_format($trx->total_amount ?? $trx->total_price ?? 0, 0, ',', '.') }}
                                    </p>
                                    
                                    <div class="flex flex-col gap-2 items-end">
                                        <a href="{{ route('customer.invoice', $trx->invoice_number ?? $trx->id) }}" class="px-4 py-1.5 rounded-lg border border-slate-200 text-slate-600 font-bold text-[10px] uppercase tracking-wider hover:bg-slate-50 hover:text-amber-600 transition-all flex items-center gap-1.5 shadow-sm">
                                            <i class="fa-solid fa-file-invoice"></i> Lihat Nota
                                        </a>

                                        @if(in_array($status, ['pending', 'unpaid', 'menunggu']) && !empty($trx->snap_token))
                                            <button onclick="payTransaction('{{ $trx->snap_token }}', '{{ $trx->invoice_number }}')" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-amber-400 to-amber-500 text-slate-900 font-black text-[10px] uppercase tracking-wider hover:brightness-105 transition-all shadow-sm">
                                                Bayar Sekarang
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    {{-- Tampilan kalau riwayat transaksi kosong karena filter --}}
                    <div class="py-20 text-center rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <i class="fa-solid fa-folder-open text-5xl text-slate-200 mb-4"></i>
                        <p class="text-base text-slate-500 font-bold">Tidak ada transaksi ditemukan</p>
                        <p class="text-xs text-slate-400 mt-1">Belum ada aktivitas transaksi untuk kategori filter status ini.</p>
                    </div>
                @endif
            </div>
        </main>
    </div>

    {{-- JAVASCRIPT MIDTRANS INTEGRASI SINKRON --}}
    <script>
        function payTransaction(snapToken, invoiceNumber) {
            window.snap.pay(snapToken, {
                onSuccess: async function(result) {
                    await updateStatusToBackend(invoiceNumber, 'settlement');
                },
                onPending: async function(result) {
                    await updateStatusToBackend(invoiceNumber, 'pending');
                },
                onError: async function(result) {
                    await updateStatusToBackend(invoiceNumber, 'cancel');
                },
                onClose: function() {
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran.');
                }
            });
        }

        async function updateStatusToBackend(invoiceNumber, status) {
            try {
                const response = await fetch("{{ route('customer.payment.update-status') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ 
                        order_id: invoiceNumber, 
                        transaction_status: status 
                    })
                });
                
                const data = await response.json();
                if (data.status === 'success') {
                    window.location.reload(); 
                } else {
                    alert('Peringatan Sistem: ' + data.message);
                }
            } catch (e) {
                alert('Terjadi kesalahan fatal koneksi saat melapor ke server Laravel.');
                console.error('Gagal update status:', e);
            }
        }
    </script>
</body>
</html>