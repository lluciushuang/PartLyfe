<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk | Partlyfe Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#020617] text-slate-200 flex h-screen overflow-hidden">

    @include('layouts.admin-sidebar')
    

    <main class="flex-1 overflow-y-auto p-10 relative">
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-indigo-600/5 rounded-full filter blur-[120px] pointer-events-none"></div>

        <div class="flex justify-between items-center mb-10 relative z-10">
            <div>
                <h2 class="text-2xl font-black text-white">Produk & Inventori</h2>
                <p class="text-xs text-slate-500">Total {{ $products->total() }} SKU terdaftar dalam sistem.</p>
            </div>
            <button class="bg-indigo-500 hover:bg-indigo-400 text-white font-bold py-2.5 px-6 rounded-xl transition shadow-[0_0_20px_rgba(99,102,241,0.3)]">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Produk
            </button>
        </div>

        <div class="bg-slate-900/40 backdrop-blur-md rounded-3xl border border-white/5 overflow-hidden relative z-10">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-[10px] uppercase tracking-[0.2em] text-slate-500">
                    <tr>
                        <th class="px-8 py-5">Informasi Produk</th>
                        <th class="px-8 py-5 text-center">Stok</th>
                        <th class="px-8 py-5 text-right">Harga Satuan</th>
                        <th class="px-8 py-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm">
                    
                    @forelse($products as $product)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="px-8 py-5">
                                <p class="font-bold text-white">{{ $product->name }}</p>
                                <p class="text-[10px] text-slate-500 font-mono mt-1">SKU: {{ $product->item_code }}</p>
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($product->current_stock <= 5)
                                    <span class="bg-rose-500/10 text-rose-500 text-[10px] font-black px-3 py-1 rounded-full border border-rose-500/20">SISA {{ $product->current_stock }}</span>
                                @else
                                    <span class="bg-emerald-500/10 text-emerald-500 text-[10px] font-black px-3 py-1 rounded-full border border-emerald-500/20">{{ $product->current_stock }} PCS</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right font-black text-white">
                                Rp {{ number_format($product->prices->first()->price ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 text-center">
                                <button class="text-indigo-400 hover:text-white transition mx-2" title="Edit Data"><i class="fa-solid fa-pen"></i></button>
                                <button class="text-rose-500 hover:text-rose-400 transition mx-2" title="Hapus Produk"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-slate-500 font-bold">
                                Belum ada data produk di database.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        <div class="mt-6 relative z-10">
            {{ $products->links() }}
        </div>

    </main>
</body>
</html>