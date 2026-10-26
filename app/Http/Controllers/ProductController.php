<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Tampilkan daftar produk (bisa dilihat Admin/Staff untuk kelola, atau User untuk belanja).
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        return view('products.index', compact('products'));
    }

    /**
     * Form tambah produk baru (Hanya untuk Admin & Staff).
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Simpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku'           => 'required|string|max:50|unique:products,sku',
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'sku'            => $request->sku,
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'selling_price'  => $request->selling_price,
            'price'          => $request->selling_price,          // Mengatasi error kolom price
            'purchase_price' => $request->selling_price,          // Mengatasi error kolom purchase_price
            'stock'          => $request->stock,
            'description'    => $request->description,
            'image'          => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk sembako beserta kode SKU dan foto berhasil ditambahkan!');
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update data produk di database.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'sku'           => 'required|string|max:50|unique:products,sku,' . $product->id,
            'category_id'   => 'required|exists:categories,id',
            'name'          => 'required|string|max:255',
            'selling_price' => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'sku'            => $request->sku,
            'category_id'    => $request->category_id,
            'name'           => $request->name,
            'selling_price'  => $request->selling_price,
            'price'          => $request->selling_price,          // Mengatasi error kolom price
            'purchase_price' => $request->selling_price,          // Mengatasi error kolom purchase_price
            'stock'          => $request->stock,
            'description'    => $request->description,
            'image'          => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Data produk sembako berhasil diperbarui!');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk sembako berhasil dihapus!');
    }
}