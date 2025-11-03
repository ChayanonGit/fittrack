<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Contracts\View\View;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;


class OrderDetailController extends SearchableController
{
    const MAX_ITEMS = 5;

    #[\Override]
    function getQuery(?int $userId = null): Builder
    {
        $query = OrderDetail::orderBy('code');

        if ($userId) {
            $query->where('user_id', $userId); // สมมติว่ามี user_id ใน order_detail
        }

        return $query;
    }

    public function vieworder(ServerRequestInterface $request): View
    {
        Gate::authorize('viewAny', OrderDetail::class);

        $criteria = $this->prepareCriteria($request->getQueryParams());
        $userId = auth()->id(); // ใช้ user ที่ login

        $orders = Order::where('user_id', $userId)
            ->with([
                'orderDetails.product',
                'orderDetails.FitnessCourse' // เพิ่ม relation สำหรับคลาส
            ])
            ->paginate(self::MAX_ITEMS);

        return view('orderlist.view-order', [
            'criteria' => $criteria,
            'orders' => $orders,
        ]);
    }

    public function orderDetail(ServerRequestInterface $request, String $OrderCode,): View
    {
        
        Gate::authorize('viewAny', OrderDetail::class);

        $criteria = $this->prepareCriteria($request->getQueryParams());
        $order = Order::with(['orderDetails.product'])
            ->where('code', $OrderCode)
            ->firstOrFail();

        return view('orderlist.view-detail', [
            'order' => $order,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function delete(ServerRequestInterface $request, $OrderCode): RedirectResponse
    {
        // หา order ก่อน
        $order = Order::where('code', $OrderCode)->firstOrFail();

        // ตรวจสอบสิทธิ์ก่อนลบ

        try {
            $orderCode = $order->code; // เก็บไว้ก่อนลบ
            $order->delete();

            // redirect หลังลบเสร็จ
            return redirect(
                session()->get('bookmarks.orders.view', route('order.view-order'))
            )->with('success', "Order {$orderCode} was deleted.");
        } catch (QueryException $excp) {
            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function approve($orderCode)
    {
        $order = Order::where('code', $orderCode)->firstOrFail();

        // เช็คว่า order ยังไม่ถูก approve
        if ($order->status !== 'paid') {
            // เปลี่ยน status เป็น paid
            $order->status = 'paid';
            $order->save();

            // ลบ stock ของแต่ละ product
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                if ($product) {
                    // ลด stock เท่ากับ quantity
                    $product->stock = max(0, $product->stock - $detail->quantity);
                    $product->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Order payment success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
