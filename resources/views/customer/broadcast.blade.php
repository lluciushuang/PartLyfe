<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabar Admin | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans text-slate-800 h-screen overflow-hidden flex">

    <!-- SIDEBAR NAVIGASI UTAMA -->
    <aside class="w-72 bg-slate-900 text-slate-300 flex flex-col h-full shadow-2xl z-20 flex-shrink-0">
        <div class="h-20 flex items-center px-8 border-b border-slate-800 bg-slate-950">
            <a href="{{ route('customer.dashboard') }}" class="text-3xl font-black text-white tracking-tighter">PARTLYFE<span class="text-amber-500">.</span></a>
        </div>

        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 scrollbar-hide">
            <p class="px-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-4">Menu Utama</p>
            <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors font-semibold"><i class="fa-solid fa-store w-5 text-center text-lg"></i> Katalog Produk</a>

            <div class="group cursor-pointer">
                <a href="{{ route('customer.transactions') }}" class="flex items-center justify-between px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors font-semibold">
                    <div class="flex items-center gap-4"><i class="fa-solid fa-receipt w-5 text-center text-lg"></i> Transaksi Saya</div>
                    <i class="fa-solid fa-chevron-down text-xs transition-transform group-hover:rotate-180"></i>
                </a>
            </div>

            <!-- AKTIF DI MENU INI -->
            <a href="{{ route('customer.broadcast') }}" class="flex items-center justify-between px-4 py-3 rounded-xl font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/20">
                <div class="flex items-center gap-4"><i class="fa-solid fa-tower-broadcast w-5 text-center text-lg"></i> Kabar Admin</div>
            </a>

            <a href="{{ route('customer.ai-chat') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors font-semibold border border-transparent hover:border-slate-700 mt-2 relative overflow-hidden group">
                <i class="fa-solid fa-robot w-5 text-center text-lg text-indigo-400"></i><span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-purple-400">Tanya Mekanik AI</span>
            </a>

            <p class="px-4 text-[11px] font-bold text-slate-500 uppercase tracking-widest mb-2 mt-8">Pengaturan</p>
            <a href="{{ route('customer.profile') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors font-semibold"><i class="fa-solid fa-user-gear w-5 text-center text-lg"></i> Profil & Alamat</a>
        </div>
    </aside>

    <!-- AREA KONTEN UTAMA -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50 relative">
        <header class="h-20 bg-white border-b border-slate-200 shadow-sm flex items-center justify-between px-8 flex-shrink-0 z-10">
            <h2 class="text-xl font-bold text-slate-800">Pusat Informasi</h2>
            <div class="flex items-center gap-6">
                <a href="{{ route('customer.wishlist') }}" class="relative text-slate-400 hover:text-rose-500 transition cursor-pointer"><i class="fa-solid fa-heart text-2xl"></i></a>
                <a href="{{ route('customer.cart') }}" class="relative text-slate-400 hover:text-amber-500 transition cursor-pointer"><i class="fa-solid fa-cart-shopping text-2xl"></i></a>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide max-w-4xl mx-auto w-full">
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-900">Kabar Admin</h1>
                <p class="text-slate-500 mt-1">Pengumuman terbaru seputar stok, promo, dan info toko Sinar Jaya Motor.</p>
            </div>

            <div class="space-y-6">
                <!-- Card Notifikasi 1 -->
                <div class="bg-white p-6 rounded-2xl border border-amber-200 shadow-sm flex gap-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-amber-500"></div>
                    <div class="w-12 h-12 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center text-xl flex-shrink-0"><i class="fa-solid fa-bullhorn"></i></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h3 class="font-bold text-lg text-slate-900">Promo Oli Motul Akhir Bulan!</h3>
                            <span class="bg-rose-100 text-rose-600 text-[10px] font-black px-2 py-0.5 rounded uppercase tracking-wider">Baru</span>
                        </div>
                        <p class="text-xs text-slate-400 mb-3"><i class="fa-regular fa-clock"></i> Hari ini, 09:00 WIB</p>
                        <p class="text-slate-600 text-sm leading-relaxed">Dapatkan diskon hingga 15% untuk setiap pembelian Oli Mesin Motul all varian. Berlaku kelipatan, jangan sampai kehabisan stok ya bosku!</p>
                    </div>
                </div>

                <!-- Card Notifikasi 2 -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex gap-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-indigo-500"></div>
                    <div class="w-12 h-12 bg-indigo-100 text-indigo-500 rounded-full flex items-center justify-center text-xl flex-shrink-0"><i class="fa-solid fa-robot"></i></div>
                    <div>
                        <h3 class="font-bold text-lg text-slate-900 mb-1">Fitur Mekanik AI Kini Tersedia</h3>
                        <p class="text-xs text-slate-400 mb-3"><i class="fa-regular fa-clock"></i> 2 hari yang lalu</p>
                        <p class="text-slate-600 text-sm leading-relaxed">Bingung kampas rem mana yang cocok untuk motormu? Sekarang kamu bisa langsung tanya ke Chatbot AI kita yang siap membantu 24/7. Cobain sekarang di menu samping!</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>