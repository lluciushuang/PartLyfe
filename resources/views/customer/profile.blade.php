<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun | Partlyfe</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link class="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .toko-card {
            background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; box-shadow: 0 1px 6px 0 rgba(49, 53, 59, 0.08);
        }
        .tab-btn {
            color: #6b7280; font-weight: 600; padding: 16px 24px; border-bottom: 3px solid transparent; transition: all 0.2s; white-space: nowrap;
        }
        .tab-btn:hover { color: #f59e0b; }
        .tab-active { color: #f59e0b !important; border-bottom-color: #f59e0b !important; font-weight: 700; }
        .input-toko {
            width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 14px; font-size: 14px; color: #374151; outline: none; transition: all 0.2s;
        }
        .input-toko:focus { border-color: #f59e0b; }
        .input-toko[readonly] { background-color: #f3f4f6; color: #9ca3af; cursor: not-allowed; }
        
        .avatar-box {
            width: 100%; aspect-ratio: 1/1; border-radius: 8px; overflow: hidden; position: relative; border: 1px solid #e5e7eb;
        }
        .avatar-overlay {
            position: absolute; bottom: 0; width: 100%; background: rgba(0,0,0,0.5); color: white; text-align: center; padding: 8px 0; font-size: 12px; font-weight: 700; cursor: pointer; transition: background 0.2s;
        }
        .avatar-overlay:hover { background: rgba(0,0,0,0.7); }
    </style>
</head>

<body class="bg-[#f3f4f6] font-sans text-slate-700 h-screen overflow-hidden flex">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

        {{-- Toast Notifikasi --}}
        @if(session('success'))
            <div id="toast" class="fixed top-10 left-1/2 transform -translate-x-1/2 z-[9999] bg-emerald-50 border border-emerald-200 text-emerald-600 px-6 py-3 rounded-xl shadow-lg font-bold text-sm flex items-center gap-3">
                <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
            </div>
            <script>setTimeout(() => document.getElementById('toast').remove(), 3000);</script>
        @endif

        {{-- Header --}}
        <header class="h-16 bg-white border-b border-slate-200 flex items-center px-8 flex-shrink-0 z-50">
            <h1 class="text-lg font-black text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-user-gear text-amber-500"></i> Pengaturan Akun
            </h1>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-[1000px] mx-auto flex flex-col md:flex-row gap-6 items-start">
                
                {{-- SISI KIRI: MANAJEMEN FOTO & KEAMANAN SINGKAT --}}
                <div class="w-full md:w-[320px] flex flex-col gap-4">
                    <div class="toko-card p-6 flex flex-col items-center">
                        
                        {{-- Form Upload Foto Langsung Tersubmit Saat Dipilih --}}
                        <form action="{{ route('profile.update.avatar') }}" method="POST" enctype="multipart/form-data" id="avatarForm" class="w-full">
                            @csrf
                            <div class="avatar-box mb-4 bg-slate-100 flex items-center justify-center">
                                @if(Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-user text-6xl text-slate-300"></i>
                                @endif
                                
                                <label for="avatarUpload" class="avatar-overlay">Ubah Foto</label>
                                <input type="file" name="avatar" id="avatarUpload" class="hidden" accept=".jpg,.jpeg,.png" onchange="document.getElementById('avatarForm').submit();">
                            </div>
                        </form>

                        <button onclick="document.getElementById('avatarUpload').click()" class="w-full border border-slate-300 rounded-lg py-2 text-sm font-bold text-slate-600 hover:bg-slate-50 transition-all mb-4">
                            Pilih Foto
                        </button>
                        
                        <p class="text-[10px] text-slate-400 leading-relaxed text-center">
                            Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG
                        </p>
                    </div>

                    <div class="toko-card p-4 space-y-2">
                        <button onclick="switchTab('keamanan')" class="w-full text-left px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-lg flex items-center gap-3">
                            <i class="fa-solid fa-key w-4 text-center"></i> Buat Kata Sandi
                        </button>
                        <button onclick="switchTab('keamanan')" class="w-full text-left px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50 rounded-lg flex items-center gap-3">
                            <i class="fa-solid fa-lock w-4 text-center"></i> PIN Keamanan
                        </button>
                    </div>
                </div>

                {{-- SISI KANAN: TAB KONTEN --}}
                <div class="flex-1 w-full toko-card overflow-hidden">
                    
                    {{-- Navigasi Tab --}}
                    <div class="flex border-b border-slate-200 overflow-x-auto no-scrollbar bg-white">
                        <button onclick="switchTab('biodata')" id="tab-biodata" class="tab-btn tab-active">Biodata Diri</button>
                        <button onclick="switchTab('alamat')" id="tab-alamat" class="tab-btn">Daftar Alamat</button>
                        <button onclick="switchTab('keamanan')" id="tab-keamanan" class="tab-btn">Keamanan</button>
                    </div>

                    {{-- KONTEN TAB 1: BIODATA DIRI --}}
                    <div id="content-biodata" class="p-8 block">
                        <h3 class="text-sm font-bold text-slate-800 mb-6">Ubah Biodata Diri</h3>
                        <form action="{{ route('profile.update.bio') }}" method="POST" class="space-y-5 max-w-lg">
                            @csrf @method('PUT')
                            
                            <div class="grid grid-cols-3 items-center gap-4">
                                <label class="text-sm font-semibold text-slate-500">Nama</label>
                                <div class="col-span-2">
                                    <input type="text" name="name" class="input-toko" value="{{ Auth::user()->name }}" required>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 items-center gap-4">
                                <label class="text-sm font-semibold text-slate-500">Tanggal Lahir</label>
                                <div class="col-span-2">
                                    <input type="date" name="dob" class="input-toko" value="{{ Auth::user()->dob }}">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-3 items-center gap-4">
                                <label class="text-sm font-semibold text-slate-500">Jenis Kelamin</label>
                                <div class="col-span-2 flex gap-4">
                                    <label class="flex items-center gap-2 text-sm"><input type="radio" name="gender" value="Laki-laki" {{ Auth::user()->gender === 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                                    <label class="flex items-center gap-2 text-sm"><input type="radio" name="gender" value="Perempuan" {{ Auth::user()->gender === 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
                                </div>
                            </div>

                            <h3 class="text-sm font-bold text-slate-800 pt-4 mb-4">Ubah Kontak</h3>

                            <div class="grid grid-cols-3 items-center gap-4">
                                <label class="text-sm font-semibold text-slate-500">Email</label>
                                <div class="col-span-2">
                                    <input type="email" value="{{ Auth::user()->email }}" class="input-toko" readonly>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 items-center gap-4">
                                <label class="text-sm font-semibold text-slate-500">Nomor HP</label>
                                <div class="col-span-2">
                                    <input type="text" name="phone" class="input-toko" value="{{ Auth::user()->phone }}" placeholder="Contoh: 08123456789">
                                </div>
                            </div>

                            <div class="pt-4">
                                <button type="submit" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-sm transition-colors">Simpan Biodata</button>
                            </div>
                        </form>
                    </div>

                    {{-- KONTEN TAB 2: DAFTAR ALAMAT --}}
                    <div id="content-alamat" class="p-8 hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-sm font-bold text-slate-800">Alamat Pengiriman Suku Cadang</h3>
                        </div>
                        <form action="{{ route('profile.update.address') }}" method="POST">
                            @csrf @method('PUT')
                            <div class="border border-slate-200 rounded-xl p-5 mb-4 bg-slate-50">
                                <label class="block text-sm font-semibold text-slate-600 mb-2">Alamat Lengkap (Rumah / Bengkel)</label>
                                <textarea name="address" rows="4" class="input-toko" placeholder="Contoh: Bengkel Sinar Jaya Motor, Jl. Raya Darmo No 123, Surabaya..." required>{{ Auth::user()->address }}</textarea>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-sm transition-colors">Simpan Alamat</button>
                        </form>
                    </div>

                    {{-- KONTEN TAB 3: KEAMANAN --}}
                    <div id="content-keamanan" class="p-8 hidden">
                        <h3 class="text-sm font-bold text-slate-800 mb-6">Pengaturan Keamanan Akun</h3>
                        <form action="{{ route('profile.update.security') }}" method="POST" class="space-y-4 max-w-lg">
                            @csrf @method('PUT')
                            <div class="border border-slate-200 rounded-xl p-5 space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-600 mb-2">Ubah Kata Sandi Baru</label>
                                    <input type="password" name="password" class="input-toko" placeholder="Kosongkan jika tidak ingin mengubah sandi">
                                </div>
                                <hr class="border-slate-100">
                                <div>
                                    <label class="block text-sm font-semibold text-slate-600 mb-2">Atur PIN Keamanan (6 Digit)</label>
                                    <input type="password" name="pin" maxlength="6" class="input-toko" placeholder="Masukkan 6 digit angka rahasia">
                                </div>
                            </div>
                            <button type="submit" class="px-6 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg text-sm transition-colors">Perbarui Keamanan</button>
                        </form>
                    </div>

                </div>
            </div>
        </main>
    </div>

    {{-- SCRIPT TAB NAVIGATION --}}
    <script>
        function switchTab(tabId) {
            // Sembunyikan semua tab content
            document.getElementById('content-biodata').classList.add('hidden');
            document.getElementById('content-alamat').classList.add('hidden');
            document.getElementById('content-keamanan').classList.add('hidden');
            
            // Matikan warna aktif di semua tombol tab
            document.getElementById('tab-biodata').classList.remove('tab-active');
            document.getElementById('tab-alamat').classList.remove('tab-active');
            document.getElementById('tab-keamanan').classList.remove('tab-active');

            // Aktifkan yang dipilih
            document.getElementById('content-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.add('tab-active');
        }
    </script>
</body>
</html>