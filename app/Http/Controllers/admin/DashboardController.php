<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Menampilkan halaman Dashboard Overview Utama Admin
    public function index()
    {
        // Menghitung statistik global
        $totalProducts = Product::count();
        $totalCustomers = User::whereIn('role', ['b2c', 'b2b'])->count();
        $totalTransactions = Transaction::count();
        
        // Menghitung total pendapatan (asumsi kolomnya bernama total_amount di tabel transactions)
        $totalRevenue = Transaction::sum('total_amount'); 

        // Mengambil 5 transaksi paling baru beserta data pelanggan yang membeli
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        // Mengambil produk yang stoknya 5 ke bawah
        $lowStockItems = Product::where('current_stock', '<=', 5)->take(5)->get();
        $lowStockCount = Product::where('current_stock', '<=', 5)->count();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCustomers', 
            'totalTransactions',
            'totalRevenue',
            'recentTransactions',
            'lowStockItems',
            'lowStockCount'
        ));
    }

    // 1. Menampilkan Semua Pelanggan (B2C & B2B) dari Database
    public function customers()
    {
        // Mengambil semua user pelanggan, diurutkan dari yang terbaru
        $customers = User::whereIn('role', ['b2c', 'b2b'])->latest()->get();

        return view('admin.customers', compact('customers'));
    }

    // 2. Melihat Detail Akun & Riwayat Pembelian Pelanggan
    public function showCustomer($id)
    {
        $customer = User::findOrFail($id);
        
        // Mengambil seluruh nota transaksi milik pelanggan terkait (relasi ke detail)
        $transactions = Transaction::where('user_id', $id)->latest()->get();

        return view('admin.customers.show', compact('customer', 'transactions'));
    }

    // 3. Menangani Fitur Upgrade Tingkat Akun dari Retail (B2C) ke Mitra Bisnis (B2B)
    public function upgradeToB2b($id)
    {
        $customer = User::findOrFail($id);
        
        if ($customer->role === 'b2c') {
            $customer->role = 'b2b';
            $customer->save();
            
            return redirect()->back()->with('success', "Berhasil! Akun {$customer->name} kini resmi di-upgrade menjadi Mitra B2B.");
        }

        return redirect()->back()->with('error', 'Pengguna ini sudah berstatus sebagai mitra B2B.');
    }
}