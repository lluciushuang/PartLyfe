<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinar Jaya POS - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-gray-200 h-screen overflow-hidden flex font-sans">

    <div class="w-2/3 flex flex-col h-full border-r border-gray-800">
        
        <header class="bg-gray-900 p-4 flex justify-between items-center border-b border-gray-800 shadow-sm">
            <div>
                <h1 class="text-xl font-bold text-white tracking-wider">SINAR JAYA <span class="text-amber-500">POS</span></h1>
                <p class="text-xs text-gray-400 mt-1">Sistem Kasir Terintegrasi</p>
            </div>
            <div class="flex gap-3">
                <input type="text" placeholder="🔍 Cari nama barang / SKU..." class="bg-gray-800 text-sm rounded-lg px-4 py-2 border border-gray-700 focus:outline-none focus:border-amber-500 w-64">
                <button class="bg-gray-800 hover:bg-gray-700 p-2 rounded-lg border border-gray-700">⚙️</button>
            </div>
        </header>

        <div class="p-4 flex gap-2 overflow-x-auto bg-gray-950 border-b border-gray-900 shadow-inner">
            <button class="bg-amber-500 text-gray-950 px-4 py-1.5 rounded-full text-sm font-semibold">Semua</button>
            <button class="bg-gray-800 hover:bg-gray-700 px-4 py-1.5 rounded-full text-sm border border-gray-700">Oli Mesin</button>
            <button class="bg-gray-800 hover:bg-gray-700 px-4 py-1.5 rounded-full text-sm border border-gray-700">Pengapian</button>
            <button class="bg-gray-800 hover:bg-gray-700 px-4 py-1.5 rounded-full text-sm border border-gray-700">Ban & Velg</button>
        </div>

        <div class="p-4 grid grid-cols-3 gap-4 overflow-y-auto h-full p-4">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 cursor-pointer hover:border-amber-500 transition shadow-lg group relative overflow-hidden">
                <div class="h-24 bg-gray-800 rounded-lg mb-3 flex items-center justify-center text-3xl">🛢️</div>
                <div class="text-xs text-amber-500 font-mono mb-1">OLI-YMH-01</div>
                <h3 class="font-bold text-sm text-white leading-tight">Yamalube Super Sport 1L</h3>
                <div class="flex justify-between items-end mt-2">
                    <span class="text-lg font-bold text-white">Rp 55.000</span>
                    <span class="text-xs bg-gray-800 px-2 py-1 rounded text-gray-400">Stok: 50</span>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 cursor-pointer hover:border-amber-500 transition shadow-lg relative">
                <div class="h-24 bg-gray-800 rounded-lg mb-3 flex items-center justify-center text-3xl">⚡</div>
                <div class="text-xs text-amber-500 font-mono mb-1">BUS-NGK-01</div>
                <h3 class="font-bold text-sm text-white leading-tight">Busi NGK CPR9EA-9</h3>
                <div class="flex justify-between items-end mt-2">
                    <span class="text-lg font-bold text-white">Rp 18.000</span>
                    <span class="text-xs bg-red-900/50 text-red-400 px-2 py-1 rounded">Stok: 5</span>
                </div>
            </div>
            
            </div>
    </div>

    <div class="w-1/3 bg-gray-900 flex flex-col h-full shadow-2xl z-10 relative">
        <div class="p-4 border-b border-gray-800">
            <h2 class="text-lg font-bold text-white mb-2">Nota Penjualan Baru</h2>
            <div class="flex justify-between text-sm text-gray-400">
                <span>Pelanggan Umum (Retail)</span>
                <span class="text-amber-500 cursor-pointer">Ganti ></span>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            <div class="flex justify-between items-center bg-gray-800/50 p-3 rounded-lg border border-gray-700">
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-white">Yamalube Super Sport</h4>
                    <p class="text-xs text-gray-400">Rp 55.000</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center hover:bg-gray-600">-</button>
                    <span class="font-bold">2</span>
                    <button class="w-6 h-6 rounded-full bg-amber-500 text-gray-950 flex items-center justify-center font-bold hover:bg-amber-400">+</button>
                </div>
                <div class="w-20 text-right font-bold text-sm">Rp 110.000</div>
            </div>
        </div>

        <div class="p-4 bg-gray-950 border-t border-gray-800">
            <div class="flex justify-between text-gray-400 text-sm mb-2">
                <span>Subtotal</span>
                <span>Rp 110.000</span>
            </div>
            <div class="flex justify-between text-gray-400 text-sm mb-4">
                <span>Pajak (0%)</span>
                <span>Rp 0</span>
            </div>
            <div class="flex justify-between text-white font-bold text-2xl mb-6">
                <span>TOTAL</span>
                <span class="text-amber-500">Rp 110.000</span>
            </div>
            
            <button class="w-full bg-amber-500 hover:bg-amber-400 text-gray-950 font-bold text-lg py-4 rounded-xl shadow-[0_0_15px_rgba(245,158,11,0.4)] transition duration-200">
                BAYAR SEKARANG
            </button>
        </div>
    </div>

</body>
</html>