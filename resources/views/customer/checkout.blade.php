<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pembayaran | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen flex items-center justify-center selection:bg-emerald-500 selection:text-white">

    <div class="absolute w-[500px] h-[500px] bg-emerald-600/10 rounded-full filter blur-[100px] pointer-events-none z-0"></div>

    <div class="glass-card rounded-3xl p-10 w-full max-w-md relative z-10 border border-white/10 shadow-[0_0_30px_rgba(16,185,129,0.1)]">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/30">
                <i class="fa-solid fa-wallet text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black text-white">Ringkasan Pesanan</h1>
            <p class="text-slate-400 text-sm mt-1">Selesaikan pembayaran Anda</p>
        </div>

        <div class="space-y-4 mb-8">
            <div class="flex justify-between items-center pb-4 border-b border-white/5">
                <span class="text-slate-400">ID Pesanan</span>
                <span class="font-bold text-white">{{ $orderId }}</span>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-white/5">
                <span class="text-slate-400">Total Tagihan</span>
                <span class="text-2xl font-black text-emerald-400">Rp {{ number_format($grossAmount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center pb-4 border-b border-white/5">
                <span class="text-slate-400">Pelanggan</span>
                <span class="font-bold text-white">{{ Auth::user()->name }}</span>
            </div>
        </div>

        <button id="pay-button" class="w-full py-4 rounded-xl bg-emerald-600 text-white font-bold text-lg hover:bg-emerald-500 transition-colors shadow-[0_0_20px_rgba(16,185,129,0.4)] flex items-center justify-center gap-2">
            <i class="fa-solid fa-lock text-sm"></i> Bayar Sekarang
        </button>
        
        <div class="text-center mt-6">
            <a href="{{ route('customer.dashboard') }}" class="text-sm text-slate-500 hover:text-white transition-colors">Batal & Kembali</a>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function () {
            // Memanggil Snap menggunakan Token yang dikirim dari Controller
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran Berhasil!");
                    // Nanti arahkan ke halaman sukses / update DB
                    window.location.href = "{{ route('customer.dashboard') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda!");
                    window.location.href = "{{ route('customer.dashboard') }}";
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                },
                onClose: function(){
                    alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        };
    </script>
</body>
</html>