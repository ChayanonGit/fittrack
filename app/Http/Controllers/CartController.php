<?php

namespace App\Http\Controllers;

use App\Models\FitnessCourse;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;

class CartController extends Controller
{
    public function viewcart(Request $request)
    {
        $cart = session()->get('cart', []);
        $grandTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        return view('cart.view-cart', [
            'cart' => $cart,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function add(Request $request, $productCode)
    {
        $product = Product::where('code', $productCode)->firstOrFail();

        // ดึง cart จาก session
        $cart = session()->get('cart', []);

        // ถ้ามีสินค้านี้อยู่แล้วให้เพิ่มจำนวน
        if (isset($cart[$productCode])) {
            $cart[$productCode]['quantity']++;
        } else {
            // ถ้ายังไม่มี เพิ่มใหม่
            $cart[$productCode] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'img' => $product->img ?? null
            ];
        }

        // เซฟกลับเข้า session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'เพิ่มสินค้าลงตะกร้าเรียบร้อย!');
    }
    public function updateQuantity(Request $request, $productCode)
    {
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity');

        if (isset($cart[$productCode])) {
            if ($quantity <= 0) {
                unset($cart[$productCode]);
            } else {
                $cart[$productCode]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        $total = $cart[$productCode]['quantity'] * $cart[$productCode]['price'] ?? 0;
        $grandTotal = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));

        return response()->json([
            'total' => number_format($total),        // ใช้ number_format แทน toLocaleString()
            'grandTotal' => number_format($grandTotal)
        ]);
    }



    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'ลบสินค้าออกจากตะกร้าแล้ว!');
    }



    // public function checkout(ServerRequestInterface $request, string $CateCode,)
    // {
    //     $cart = session()->get('cart', []);
    //     if (empty($cart)) {
    //         return redirect()->back()->with('error', 'ตะกร้าว่าง');
    //     }

    //     // คำนวณ total
    //     $grandTotal = 0;
    //     foreach ($cart as $item) {
    //         $grandTotal += $item['price'] * $item['quantity'];
    //     }

    //     // สร้าง order
    //     $order = \App\Models\Order::create([
    //         'user_id' => auth()->id(), // ถ้า login
    //         'total' => $grandTotal
    //     ]);

    //     // สร้าง order_details
    //     foreach ($cart as $code => $item) {
    //         \App\Models\OrderDetail::create([
    //             'order_id' => $order->id,
    //             'product_code' => $code,
    //             'product_name' => $item['name'],
    //             'price' => $item['price'],
    //             'quantity' => $item['quantity']
    //         ]);
    //     }

    //     // ล้าง cart
    //     session()->forget('cart');

    //     return redirect()->route('cart.view-cart')->with('success', 'ชำระเงินเรียบร้อย!');
    // }
}
