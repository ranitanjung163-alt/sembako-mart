<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan untuk Admin, Staff, dan User
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin' || $user->role === 'staff') {
            $orders = Order::with('user', 'items.product')->latest()->get();
        } else {
            $orders = Order::with('items.product')->where('user_id', $user->id)->latest()->get();
        }

        return view('orders.index', compact('orders'));
    }

    // Proses menyimpan pesanan baru dan menangkap input nama pemesan dari form
    public function store(Request $request)
    {
        $request->validate([
            'product_id'       => 'required|exists:products,id',
            'quantity'         => 'required|integer|min:1',
            'customer_name'    => 'required|string|max:255', // Wajib menangkap nama pemesan
            'phone'            => 'required|string|max:15',
            'shipping_address' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Maaf, stok produk tidak mencukupi!');
        }

        DB::beginTransaction();
        try {
            $sellingPrice = $product->selling_price ?? $product->price ?? 0;
            $totalPrice = $sellingPrice * $request->quantity;

            // Simpan data pesanan beserta customer_name yang diketik user
            $order = Order::create([
                'user_id'          => auth()->id(),
                'customer_name'    => $request->customer_name, // Menyimpan nama pemesan
                'invoice_number'   => 'ORD-' . strtoupper(uniqid()),
                'total_price'      => $totalPrice,
                'status'           => 'pending',
                'shipping_address' => $request->shipping_address,
                'phone'            => $request->phone,
            ]);

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
                'price'      => $sellingPrice,
            ]);

            $product->decrement('stock', $request->quantity);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat! Menunggu konfirmasi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan.');
        }
    }

    // Mengubah status pesanan oleh Admin/Staff
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}