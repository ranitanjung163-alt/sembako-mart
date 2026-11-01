<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;

class PurchaseController extends Controller
{
    // Menampilkan tabel riwayat barang masuk
    public function index()
    {
        $purchases = Purchase::with(['supplier', 'purchaseItems.product'])->latest()->get();
        return view('purchases.index', compact('purchases'));
    }

    // Menampilkan form tambah barang masuk (diarahkan ke purchases.create yang benar)
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchases.create', compact('suppliers', 'products'));
    }

    // Menyimpan data barang masuk & otomatis menambah stok produk
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'purchase_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan ke tabel purchases (induk)
            $purchase = Purchase::create([
                'supplier_id' => $request->supplier_id,
                'invoice_number' => 'INV-IN-' . time(),
                'total_amount' => 0, 
                'purchase_date' => $request->purchase_date,
            ]);

            // 2. Simpan ke tabel purchase_items (detail)
            PurchaseItem::create([
                'purchase_id' => $purchase->id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => 0,
                'subtotal' => 0,
            ]);

            // 3. Otomatis menambahkan stok ke tabel products
            $product = Product::findOrFail($request->product_id);
            $product->stock += $request->quantity;
            $product->save();
        });

        return redirect()->route('purchases.index')->with('success', 'Barang masuk berhasil dicatat dan stok bertambah!');
    }
}