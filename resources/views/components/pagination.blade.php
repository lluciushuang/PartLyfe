@if ($paginator->hasPages())
    <nav class="flex flex-col sm:flex-row items-center justify-between gap-4 w-full">
        
        <!-- Teks Informasi Kiri -->
        <div class="text-sm text-slate-500 font-medium">
            Menampilkan <span class="font-bold text-slate-900">{{ $paginator->firstItem() }}</span> 
            sampai <span class="font-bold text-slate-900">{{ $paginator->lastItem() }}</span> 
            dari <span class="font-bold text-slate-900">{{ $paginator->total() }}</span> hasil
        </div>

        <!-- Tombol Navigasi Kanan (Gaya Pill / Rounded) -->
        <div class="flex items-center gap-2">
            
            {{-- Tombol Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed shadow-sm">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-300 transition-colors shadow-sm">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </a>
            @endif

            {{-- Looping Angka Halaman --}}
            @foreach ($elements as $element)
                
                {{-- Pemisah Tiga Titik "..." --}}
                @if (is_string($element))
                    <span class="px-3 py-2 text-slate-400 font-bold tracking-widest">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Link Halaman --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            {{-- Halaman Aktif (Menyala Amber) --}}
                            <span class="px-4 py-2 rounded-xl bg-amber-500 border border-amber-600 text-slate-900 font-black shadow-md transform scale-105 transition-transform">
                                {{ $page }}
                            </span>
                        @else
                            {{-- Halaman Tidak Aktif --}}
                            <a href="{{ $url }}" class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold hover:bg-amber-50 hover:text-amber-600 hover:border-amber-300 hover:-translate-y-0.5 transition-all shadow-sm">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="px-3.5 py-2 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-300 transition-colors shadow-sm">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </a>
            @else
                <span class="px-3.5 py-2 rounded-xl bg-slate-100 border border-slate-200 text-slate-400 cursor-not-allowed shadow-sm">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </span>
            @endif
            
        </div>
    </nav>
@endif