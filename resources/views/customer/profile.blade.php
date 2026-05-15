<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#020617] font-sans text-slate-200 h-screen overflow-hidden flex selection:bg-indigo-500 selection:text-white">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 glass-panel flex items-center justify-between px-8 flex-shrink-0 z-50 sticky top-0 border-b border-white/5">
            <h2 class="text-xl font-black text-white flex items-center gap-3">
                <i class="fa-solid fa-user-gear text-indigo-400"></i> Pengaturan Profil
            </h2>
        </header>

        <main class="flex-1 overflow-y-auto p-8 scrollbar-hide relative z-10 w-full max-w-[800px] mx-auto">
            
            <div class="mb-8">
                <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">Informasi Pribadi</h1>
                <p class="text-slate-400 mt-2 text-sm">Kelola data diri dan alamat pengiriman pesanan Anda.</p>
            </div>

            <div class="glass-card rounded-3xl p-8 flex items-center gap-6 mb-8 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-indigo-500/10 rounded-full filter blur-[40px] translate-x-1/2 -translate-y-1/2"></div>
                
                <div class="w-24 h-24 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center text-4xl font-black text-slate-900 shadow-[0_0_20px_rgba(245,158,11,0.4)] z-10 border-4 border-slate-800">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="z-10">
                    <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                    <p class="text-slate-400 flex items-center gap-2 mt-1">
                        <i class="fa-solid fa-envelope"></i> {{ Auth::user()->email }}
                    </p>
                    <div class="mt-3 inline-block px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold">
                        <i class="fa-solid fa-shield-check mr-1"></i> Akun Terverifikasi
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-3xl p-8">
                <form action="{{ route('customer.profile.update') }}" method="POST" class="space-y-6">                    
                      @csrf
                      @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-slate-500"></i>
                                </div>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-slate-900/50 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Alamat Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-at text-slate-500"></i>
                                </div>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" disabled class="w-full bg-slate-800/50 border border-white/5 rounded-xl py-3 pl-12 pr-4 text-slate-500 cursor-not-allowed">
                            </div>
                            <p class="text-xs text-slate-500 mt-1">*Email tidak dapat diubah.</p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Nomor WhatsApp</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-brands fa-whatsapp text-slate-500"></i>
                                </div>
                                <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="0812xxxxxx" class="w-full bg-slate-900/50 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 pt-4 border-t border-white/5">
                        <label class="text-sm font-bold text-slate-400 uppercase tracking-wider">Alamat Pengiriman Utama</label>
                        <div class="relative">
                            <div class="absolute top-3.5 left-4 pointer-events-none">
                                <i class="fa-solid fa-location-dot text-slate-500"></i>
                            </div>
                            <textarea name="address" rows="3" placeholder="Universitas Ciputra, Surabaya..." class="w-full bg-slate-900/50 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all resize-none">{{ Auth::user()->address }}</textarea>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-500 transition-colors shadow-[0_0_20px_rgba(79,70,229,0.4)] flex items-center gap-2">
                            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</body>
</html>