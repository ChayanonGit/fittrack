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


class OrderController extends SearchableController
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
        Gate::authorize('view', Order::class);

        $criteria = $this->prepareCriteria($request->getQueryParams());
        $userId = $request->getQueryParams()['user_id'] ?? null;
        $orders = Order::with(['orderDetails.product', 'user'])
            ->paginate(self::MAX_ITEMS);



        return view('orders.view-order', [
            'criteria' => $criteria,
            'orders' => $orders,
        ]);
    }


    public function orderDetail(ServerRequestInterface $request, String $OrderCode,): View
    {

        $criteria = $this->prepareCriteria($request->getQueryParams());
        $order = Order::with(['orderDetails.product'])
            ->where('code', $OrderCode)
            ->firstOrFail();

        return view('orders.view-detail', [
            'order' => $order,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function delete(ServerRequestInterface $request, $OrderCode): RedirectResponse
    {

        $order = Order::where('code', $OrderCode)->firstOrFail();
        try {
            $order->delete();

            return redirect(
                session()->get('bookmarks.products.list', route('admin.order.view-order'))
            )
                ->with('success', "Product {$order->code} was deleted.");
        } catch (QueryException $excp) {

            return redirect()->back()->withErrors([
                'alert' => $excp->errorInfo[2],
            ]);
        }
    }
}
