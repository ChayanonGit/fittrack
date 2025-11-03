<?php

namespace App\Http\Controllers;

use App\Models\FitnessCourse;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Policies\CartPolicy;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewcart(Request $request)
    {
        Gate::authorize('viewcart', Cart::class);
        // ดึงข้อมูลตะกร้าสินค้าจาก session ถ้ายังไม่มีจะเป็น array ว่าง []
        $cart = session()->get('cart', []);
        // คำนวณราคารวม (grand total)
        //  array_map เพื่อคูณราคากับจำนวนของแต่ละสินค้า แล้ว array_sum รวมยอดทั้งหมด
        $grandTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        return view('cart.view-cart', [
            'cart' => $cart,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function classenroll(ServerRequestInterface $request, String $ClassCode): RedirectResponse
    {

        Gate::authorize('viewcart', Cart::class);


        $user = Auth::user();
        if (!$user) {
            abort(403, 'คุณต้องล็อกอินก่อน');
        }

        $fitnessClass = FitnessCourse::where('code', $ClassCode)->firstOrFail();


        $order = new Order();
        $order->user_id = $user->id;
        $order->status = 'pending';
        $order->total = $fitnessClass->price;
        $order->code = 'ORD' . strtoupper(uniqid());
        $order->save();


        $orderDetail = new OrderDetail();
        $orderDetail->order_id = $order->id;
        $orderDetail->fitness_courses_id     = $fitnessClass->id;
        $orderDetail->quantity = 1;
        $orderDetail->price = $fitnessClass->price;
        $orderDetail->code = 'ODR' . strtoupper(uniqid());
        $orderDetail->save();

        return redirect()->route('cart.view-cart')
            ->with('success', "คุณได้ลงทะเบียนคลาส {$fitnessClass->name} เรียบร้อยแล้ว");
    }



    //เพิ่มสินค้าเข้า cart
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
        // ตรวจสอบว่ามีสินค้านี้ในตะกร้ามั้ย
        if (isset($cart[$productCode])) {
            //ถถ้าqtyที่ส่งมา=0ให้ลบออกจาก cart
            if ($quantity <= 0) {
                unset($cart[$productCode]);
            } else {
                //ถ้าelseเพิ่มproduct
                $cart[$productCode]['quantity'] = $quantity;
            }
            session()->put('cart', $cart);
        }

        $total = $cart[$productCode]['quantity'] * $cart[$productCode]['price'] ?? 0;
        $grandTotal = array_sum(array_map(fn($item) => $item['quantity'] * $item['price'], $cart));

        // ส่งค่ากลับแบบjason ให้ javaนำไปอัปเดตหน้าเว็บ
        return response()->json([
            'total' => number_format($total),        // ใช้ number_format แทน toLocaleString()
            'grandTotal' => number_format($grandTotal)
        ]);
    }



    public function remove($id)
    {
        $cart = session()->get('cart', []);
        // ตรวจว่าสินค้าจะลบยู่ในตะกร้ามั้ย
        if (isset($cart[$id])) {
            //ลบ
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'ลบสินค้าออกจากตะกร้าแล้ว!');
    }



    public function checkout(ServerRequestInterface $request)
    {
        $cart = session()->get('cart', []);
        //เชคว่าตะกร้าว่างมั้ยถ้าว่างส่ง massageกลับไป
        if (empty($cart)) {
            return redirect()->back()->with('error', 'ตะกร้าว่าง');
        }
        //เอาไว้loopเกบราคารวม
        $grandTotal = 0;
        foreach ($cart as $item) {
            $grandTotal += $item['price'] * $item['quantity'];
        }
        // บันทึกข้อมูล
        $order = \App\Models\Order::create([
            'user_id' => auth()->id(),
            'total' => $grandTotal,
            'code' => 'ORD' . strtoupper(Str::random(6)) // สร้างรหัสแบบสุ่ม
        ]);
        // วนลูปสร้าง OrderDetail
        foreach ($cart as $code => $item) {
            $orderDetail = new \App\Models\OrderDetail();

            $orderDetail->forceFill([
                'order_id'   => $order->id,
                'product_id' => $item['product_id'],
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'code'       => 'ORD' . strtoupper(Str::random(6)),
            ])->save();

            $orderDetail->save();
        }

        session()->forget('cart');

        return redirect()->route('cart.view-cart')->with('success', 'รอการชำระเงิน!');
    }
}
