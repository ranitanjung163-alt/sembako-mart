<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\PurchaseItem;
use App\Models\OrderItem; // Model Item Pesanan User

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalStockIn = PurchaseItem::sum('quantity');
        
        // Barang Keluar HANYA dihitung dari total kuantitas pesanan online user yang statusnya 'completed'
        $totalStockout = OrderItem::whereHas('order', function($query) {
            $query->where('status', 'completed');
        })->sum('quantity');
        
        $lowStockCount = Product::where('stock', '<=', 5)->count();
        
        // Mengambil daftar produk yang stoknya menipis (<= 5)
        $lowStockItems = Product::with('category')->where('stock', '<=', 5)->get();

        $products = Product::with('category')->latest()->get();

        return view('dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalStockIn', 
            'totalStockout', 
            'lowStockCount', 
            'lowStockItems',
            'products'
        ));
    }
}