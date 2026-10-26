<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index()
    {
        $transactions = Transaction::with(['product', 'supplier', 'user'])->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    // Form tambah transaksi (pembelian/penjualan)
    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        $users = User::all(); // Mengambil data user/pemesan
        return view('transactions.create', compact('products', 'suppliers', 'users'));
    }

    // Menyimpan transaksi dan memperbarui stok produk secara otomatis
    public function store(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|exists:products,id',
            'type'        => 'required|in:purchase,sale',
            'quantity'    => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'supplier_id' => 'nullable|required_if:type,purchase|exists:suppliers,id',
            'user_id'     => 'nullable|required_if:type,sale|exists:users,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Jika transaksi adalah Penjualan (sale), pastikan stok mencukupi
        if ($request->type === 'sale' && $product->stock < $request->quantity) {
            return back()->withInput()->with('error', 'Stok produk tidak mencukupi! Sisa stok saat ini: ' . $product->stock);
        }

        DB::transaction(function () use ($request, $product) {
            // Simpan data transaksi
            Transaction::create([
                'product_id'  => $request->product_id,
                'supplier_id' => $request->type === 'purchase' ? $request->supplier_id : null,
                'user_id'     => $request->type === 'sale' ? $request->user_id : null,
                'type'        => $request->type,
                'quantity'    => $request->quantity,
                'total_price' => $request->total_price,
            ]);

            // Update stok produk otomatis
            if ($request->type === 'purchase') {
                $product->increment('stock', $request->quantity); // Barang masuk menambah stok
            } else {
                $product->decrement('stock', $request->quantity); // Barang keluar mengurangi stok
            }
        });

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dicatat dan stok produk telah diperbarui!');
    }
}