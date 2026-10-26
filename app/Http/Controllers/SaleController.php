<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['user', 'items.product'])->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'                 => 'required|array|min:1',
            'items.*.product_id'    => 'required|exists:products,id',
            'items.*.quantity'      => 'required|integer|min:1',
            'paid_amount'           => 'required|numeric|min:0',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $totalAmount = 0;
                $saleItemsData = [];

                foreach ($request->items as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);

                    if (!$product) {
                        throw new \Exception("Produk tidak ditemukan.");
                    }

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Stok tidak mencukupi untuk produk: {$product->name}. Sisa stok: {$product->stock}");
                    }

                    // Deteksi otomatis kolom harga di database produk
                    $unitPrice = 0;
                    if (isset($product->selling_price) && $product->selling_price > 0) {
                        $unitPrice = $product->selling_price;
                    } elseif (isset($product->price) && $product->price > 0) {
                        $unitPrice = $product->price;
                    } elseif (isset($product->harga) && $product->harga > 0) {
                        $unitPrice = $product->harga;
                    } elseif (isset($product->harga_jual) && $product->harga_jual > 0) {
                        $unitPrice = $product->harga_jual;
                    } elseif (isset($product->purchase_price) && $product->purchase_price > 0) {
                        $unitPrice = $product->purchase_price;
                    } else {
                        $unitPrice = 10000; // Harga default pengaman
                    }
                    
                    // Perhitungan subtotal (operator perkalian sudah diperbaiki)
                    $subtotal = $unitPrice * $item['quantity'];
                    $totalAmount += $subtotal;

                    $saleItemsData[] = [
                        'product_id' => $product->id,
                        'quantity'   => $item['quantity'],
                        'unit_price' => $unitPrice,
                        'subtotal'   => $subtotal,
                    ];

                    // Kurangi stok produk
                    $product->stock -= $item['quantity'];
                    $product->save();
                }

                if ($request->paid_amount < $totalAmount) {
                    throw new \Exception("Uang yang dibayarkan kurang dari total belanja (Rp " . number_format($totalAmount, 0, ',', '.') . ").");
                }

                // Perhitungan kembalian (operator pengurangan sudah diperbaiki)
                $changeAmount = $request->paid_amount - $totalAmount;

                // Simpan Header Penjualan
                $sale = Sale::create([
                    'user_id'        => auth()->id(),
                    'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
                    'total_amount'   => $totalAmount,
                    'paid_amount'    => $request->paid_amount,
                    'change_amount'  => $changeAmount,
                ]);

                // Simpan Detail Item Penjualan
                foreach ($saleItemsData as $data) {
                    $sale->items()->create($data);
                }

                return redirect()->route('sales.index')->with('success', 'Transaksi berhasil disimpan dan stok telah diperbarui!');
            });
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $sale->load(['user', 'items.product']);
        return view('sales.show', compact('sale'));
    }
}