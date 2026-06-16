<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('kasir.pos', compact('products', 'cart', 'total'));
    }

    public function addToCart(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['quantity'] < $product->stock) {
                $cart[$product->id]['quantity']++;
            } else {
                return redirect()->back()->with('error', 'Stok tidak mencukupi.');
            }
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
        ]);

        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        if ($request->payment_amount < $totalPrice) {
            return redirect()->back()->with('error', 'Uang pembayaran kurang.');
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_price' => $totalPrice,
                'payment_amount' => $request->payment_amount,
                'change_amount' => $request->payment_amount - $totalPrice,
            ]);

            foreach ($cart as $id => $details) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $details['price'],
                    'subtotal' => $details['price'] * $details['quantity'],
                ]);

                // Update Stock
                $product = Product::find($id);
                $product->decrement('stock', $details['quantity']);
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('kasir.pos')->with('success', 'Transaksi berhasil! Kembalian: Rp ' . number_format($transaction->change_amount, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
