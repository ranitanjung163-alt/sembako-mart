<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        // Barang Masuk: Menghitung total keseluruhan akumulasi stok produk yang ada
        $totalStockIn = Product::sum('stock'); 
        
        // Barang Keluar: Menghitung total kuantitas produk yang terjual secara real-time dari tabel penjualan
        $totalStockOut = SaleItem::sum('quantity'); 
        
        // Produk dengan stok rendah (<= 5)
        $lowStockProducts = Product::where('stock', '<=', 5)->get();
        $lowStockCount = $lowStockProducts->count();

        // Mengambil semua daftar produk beserta relasi kategorinya untuk ditampilkan di dashboard
        $products = Product::with('category')->latest()->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalStockIn',
            'totalStockOut',
            'lowStockCount',
            'lowStockProducts',
            'products'
        ));
    }
}