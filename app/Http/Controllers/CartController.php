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
use Illuminate\Support\Str;

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
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'img' => $product->img 
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



    public function checkout(ServerRequestInterface $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'ตะกร้าว่าง');
        }

        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }

        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total' => $grandTotal,
            'code' => 'ORD' . strtoupper(Str::random(6))
        ]);
        foreach ($cart as $code => $item) {
            $orderDetail = new \App\Models\OrderDetail();

            // ใส่ค่า attribute ตรง ๆ หรือใช้ forceFill
            $orderDetail->forceFill([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'code'       => 'ORD' . strtoupper(Str::random(6)),
            ]);

            $orderDetail->save();
        }

        session()->forget('cart');

        return redirect()->route('cart.view-cart')->with('success', 'ชำระเงินเรียบร้อย!');
    }
}
