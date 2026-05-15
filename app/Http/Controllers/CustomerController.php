<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductPrice;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Transaction; // Tambahan untuk memanggil relasi transaksi
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    // ==========================================================
    // 1. AREA KATALOG & PRODUK UTAMA
    // ==========================================================

    public function dashboard(Request $request)
    {
        $query = Product::with('prices');

        // Fitur Pencarian (Search)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Kategori
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Fitur Urutkan (Sorting) Harga
        if ($request->has('sort')) {
            if ($request->sort == 'terendah') {
                $query->orderBy(
                    ProductPrice::select('price')
                        ->whereColumn('product_prices.product_id', 'products.id')
                        ->where('price_level', 1)
                        ->limit(1),
                    'asc'
                );
            } elseif ($request->sort == 'tertinggi') {
                $query->orderBy(
                    ProductPrice::select('price')
                        ->whereColumn('product_prices.product_id', 'products.id')
                        ->where('price_level', 1)
                        ->limit(1),
                    'desc'
                );
            }
        } else {
            // Default: Urutkan dari barang terbaru (Relevansi)
            $query->latest();
        }

        $products = $query->paginate(15)->withQueryString(); 
        $categories = Category::all();

        return view('customer.dashboard', compact('products', 'categories'));
    }

    public function productDetail($id)
    {
        $product = Product::with(['prices', 'category'])->findOrFail($id);

        $recommendations = Product::with('prices')
            ->where('id', '!=', $id) 
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('customer.product', compact('product', 'recommendations'));
    }

    public function allCategories()
    {
        $categories = Category::all();
        return view('customer.categories', compact('categories'));
    }

    // ==========================================================
    // 2. AREA KERANJANG (CART)
    // ==========================================================

    public function cart()
    {
        $cartItems = Cart::with(['product.prices'])->where('user_id', Auth::id())->latest()->get();
        return view('customer.cart', compact('cartItems'));
    }

    public function addToCart(Request $request, $product_id)
    {
        $product = Product::findOrFail($product_id);
        
        // Validasi Stok Kosong
        if ($product->current_stock <= 0) {
            return back()->with('error', 'Maaf, barang sedang habis dan tidak bisa dimasukkan ke keranjang.');
        }

        $qty = $request->input('qty', 1);
        $cart = Cart::where('user_id', Auth::id())->where('product_id', $product_id)->first();

        if ($cart) {
            if (($cart->qty + $qty) > $product->current_stock) {
                return back()->with('error', 'Gagal: Jumlah total melebihi sisa stok yang ada!');
            }
            $cart->qty += $qty;
            $cart->save();
        } else {
            if ($qty > $product->current_stock) {
                return back()->with('error', 'Gagal: Jumlah yang diminta melebihi sisa stok!');
            }
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'qty' => $qty
            ]);
        }

        return back()->with('success', 'Barang berhasil masuk keranjang!');
    }

    public function updateCart(Request $request, $id)
    {
        $cart = Cart::where('user_id', Auth::id())->findOrFail($id);
        
        $qty = $request->qty;
        if($qty > 0 && $qty <= $cart->product->current_stock) {
            $cart->update(['qty' => $qty]);
        }
        
        return back()->with('success', 'Jumlah barang diperbarui.');
    }

    public function removeFromCart($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return back()->with('success', 'Barang berhasil dibuang dari keranjang.');
    }

    // ==========================================================
    // 3. AREA WISHLIST
    // ==========================================================

    public function wishlist()
    {
        $wishlists = Wishlist::with(['product.prices'])->where('user_id', Auth::id())->latest()->get();
        return view('customer.wishlist', compact('wishlists'));
    }

    public function toggleWishlist($product_id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $product_id)->first();

        if ($wishlist) {
            $wishlist->delete();
            return back()->with('success', 'Dihapus dari Wishlist!');
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product_id
            ]);
            return back()->with('success', 'Ditambahkan ke Wishlist!');
        }
    }

    // ==========================================================
    // 4. AREA TRANSAKSI & PENGATURAN USER
    // ==========================================================

    public function transactions()
    {
        // Mengambil riwayat transaksi user beserta rincian barangnya
        $transactions = Transaction::with('details.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('customer.transactions', compact('transactions'));
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function broadcast()
    {
        return view('customer.broadcast');
    }

    public function aiChat()
    {
        return view('customer.ai-chat');
    }
}