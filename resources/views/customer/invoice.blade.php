<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota: {{ $transaction->invoice_number }} | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            body { background: white !important; color: black !important; padding: 0 !important; }
            .no-print { display: none !important; }
            .print-text-black { color: black !important; }
            .print-border { border-color: #e2e8f0 !important; }
            .print-bg-white { background: white !important; box-shadow: none !important; border: none !important; margin: 0 !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="bg-[#020617] font-sans text-slate-200 min-h-screen p-4 md:p-8 flex flex-col items-center">

    <div class="w-full max-w-3xl flex flex-col sm:flex-row justify-between items-center gap-4 mb-8 no-print z-50 relative mt-4">
        <a href="{{ route('customer.transactions') }}" class="px-6 py-3.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-700 transition shadow-lg border border-white/10 flex items-center gap-3 w-full sm:w-auto justify-center group">
            <i class="fa-solid fa-arrow-left text-amber-500 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Riwayat
        </a>
        
        <button onclick="window.print()" class="px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-500 transition shadow-[0_0_20px_rgba(79,70,229,0.4)] flex items-center gap-3 w-full sm:w-auto justify-center">
            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
        </button>
    </div>

    <div class="w-full max-w-3xl glass-card rounded-3xl p-8 md:p-14 border border-white/10 shadow-2xl print-bg-white print-border print-text-black relative overflow-hidden z-10">
        
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] pointer-events-none z-0">
            <i class="fa-solid fa-motorcycle text-[30rem]"></i>
        </div>

        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b border-white/10 print-border pb-8 mb-8 gap-6">
                <div>
                    <h1 class="text-4xl font-black text-amber-500 tracking-wider mb-1">PARTLYFE<span class="text-amber-400/50">|</span></h1>
                    <p class="text-slate-400 text-sm print-text-black mt-2">Distributor Sparepart Motor Terpercaya</p>
                    <p class="text-slate-400 text-sm print-text-black">Jl. jalanan No. 123, Surabaya</p>
                </div>
                <div class="text-left md:text-right">
                    <h2 class="text-xl font-bold text-white print-text-black">INVOICE</h2>
                    <p class="text-slate-400 font-mono mt-1 print-text-black">{{ $transaction->invoice_number }}</p>
                    
                    @php
                        $isPaid = in_array($transaction->status, ['processing', 'shipped', 'delivered']);
                        $paymentStatusText = $isPaid ? 'LUNAS' : ($transaction->status == 'cancelled' ? 'DIBATALKAN' : 'BELUM DIBAYAR');
                        $statusClass = $isPaid ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30 shadow-[0_0_15px_rgba(16,185,129,0.1)]' : 
                                      ($transaction->status == 'cancelled' ? 'bg-rose-500/10 text-rose-400 border-rose-500/30' : 
                                      'bg-amber-500/10 text-amber-400 border-amber-500/30 animate-pulse');
                    @endphp
                    <div class="mt-3 inline-block px-4 py-1.5 rounded-xl text-xs font-black uppercase tracking-wider border {{ $statusClass }}">
                        Keterangan: {{ $paymentStatusText }}
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between gap-8 mb-10">
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Ditagihkan Kepada:</p>
                    <p class="text-lg font-bold text-white print-text-black">{{ Auth::user()->name }}</p>
                    <p class="text-slate-400 text-sm print-text-black">{{ Auth::user()->phone ?? '-' }}</p>
                    <p class="text-slate-400 text-sm print-text-black">{{ Auth::user()->email }}</p>
                </div>
                <div class="text-left md:text-right">
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Tanggal Transaksi:</p>
                    <p class="text-white font-medium print-text-black">{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d F Y') }}</p>
                    <p class="text-slate-400 text-sm print-text-black">{{ $transaction->created_at->timezone('Asia/Jakarta')->format('H:i') }} WIB</p>
                </div>
            </div>

            <div class="overflow-x-auto mb-8">
                <table class="w-full text-left border-collapse min-w-[500px]">
                    <thead>
                        <tr class="border-y border-white/10 print-border text-slate-400 uppercase text-xs tracking-wider">
                            <th class="py-4 font-bold">Nama Barang</th>
                            <th class="py-4 font-bold text-center">Qty</th>
                            <th class="py-4 font-bold text-right">Harga Satuan</th>
                            <th class="py-4 font-bold text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($transaction->details as $detail)
                            <tr class="border-b border-white/5 print-border">
                                <td class="py-4 font-medium text-white print-text-black">{{ $detail->product->name }}</td>
                                <td class="py-4 text-center print-text-black">{{ $detail->qty }}</td>
                                <td class="py-4 text-right print-text-black">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="py-4 text-right font-bold text-white print-text-black">Rp {{ number_format($detail->qty * $detail->price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="flex justify-end mb-12">
                <div class="w-full md:w-1/2">
                    <div class="flex justify-between py-3 border-b border-white/10 print-border">
                        <span class="text-slate-400 font-medium print-text-black">Subtotal</span>
                        <span class="text-white print-text-black">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-white/10 print-border">
                        <span class="text-slate-400 font-medium print-text-black">Pajak (0%)</span>
                        <span class="text-white print-text-black">Rp 0</span>
                    </div>
                    <div class="flex justify-between py-4 mt-2 bg-amber-500/10 print-bg-white px-4 rounded-xl print-border border border-transparent">
                        <span class="text-xl font-black text-white uppercase print-text-black">Total Akhir</span>
                        <span class="text-2xl font-black text-amber-500">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="text-center pt-8 border-t border-white/10 print-border text-slate-500 text-sm">
                <p>Terima kasih telah berbelanja di Partlyfe.</p>
                <p>Simpan nota ini sebagai bukti transaksi Anda yang sah.</p>
            </div>
        </div>
    </div>

</body>
</html>