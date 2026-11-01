<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // Menampilkan isi keranjang belanja user
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('cart.index', compact('carts'));
    }

    // Menambahkan produk ke keranjang dari dashboard
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi!');
        }

        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $request->product_id)
                    ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dimasukkan ke keranjang belanja!');
    }

    // Menampilkan halaman form konfirmasi checkout identitas
    public function checkoutForm()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong!');
        }

        return view('cart.checkout', compact('carts'));
    }

    // FUNGSI UTAMA: Proses simpan pesanan dari keranjang ke riwayat pemesanan beserta Nama, No HP, & Alamat
    public function checkout(Request $request)
    {
        // Validasi input nama pemesan, nomor hp, dan alamat wajib diisi dari form keranjang
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
        ]);

        $carts = Cart::where('user_id', auth()->id())->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong!');
        }

        try {
            DB::transaction(function () use ($request, $carts) {
                $totalAmount = 0;
                $orderItemsData = [];

                foreach ($carts as $cart) {
                    $product = Product::lockForUpdate()->find($cart->product_id);
                    
                    if ($product->stock < $cart->quantity) {
                        throw new \Exception("Stok untuk produk {$product->name} tidak mencukupi.");
                    }

                    $price = $product->selling_price ?? $product->price ?? $product->harga ?? $product->harga_jual ?? 10000;
                    $subtotal = $price * $cart->quantity;
                    $totalAmount += $subtotal;

                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $cart->quantity,
                        'price' => $price,
                        'subtotal' => $subtotal,
                    ];

                    // Kurangi stok produk secara otomatis
                    $product->stock -= $cart->quantity;
                    $product->save();
                }

                // Ambil data user yang sedang login
                $user = auth()->user();

                // Simpan ke tabel Orders dengan nama pemesan, nomor HP, dan alamat dari form input user
                $order = Order::create([
                    'user_id' => $user->id,
                    'invoice_number' => 'INV-CART-' . strtoupper(Str::random(6)),
                    'customer_name' => $request->customer_name,
                    'phone' => $request->phone,
                    'shipping_address' => $request->shipping_address,
                    'total_price' => $totalAmount,
                    'status' => 'pending',
                ]);

                foreach ($orderItemsData as $data) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $data['product_id'],
                        'quantity' => $data['quantity'],
                        'price' => $data['price'],
                        'subtotal' => $data['subtotal'],
                    ]);
                }

                // Kosongkan keranjang setelah berhasil masuk ke riwayat
                Cart::where('user_id', auth()->id())->delete();
            });

            return redirect()->route('orders.index')->with('success', 'Pesanan dari keranjang berhasil dibuat dan masuk ke riwayat pemesanan!');
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    // Alias untuk jaga-jaga jika rute memanggil processCheckout
    public function processCheckout(Request $request)
    {
        return $this->checkout($request);
    }

    // Hapus item dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}