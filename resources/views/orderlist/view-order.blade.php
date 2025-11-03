@extends('orders.main')

@section('content')
    <h1 class="page-title">Product List</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('shop.view-shop') }}">Shop</a>
    </div>

    @foreach ($orders as $order)
        <div class="order-summary">
            <p><strong>Order #{{ $order->code }}</strong></p>

            @php
                $firstDetail = $order->orderDetails->first();
            @endphp

            @if ($firstDetail)
                @if ($firstDetail->product_id && $firstDetail->product)
                    <img src="{{ asset('storage/img_product/' . $firstDetail->product->img) }}"
                        alt="{{ $firstDetail->product->name }}" width="100">
                    <p><b>Product:</b> {{ $firstDetail->product->name }}</p>
                @elseif ($firstDetail->fitnesscourse_id && $firstDetail->fitnessCourse)
                    <img src="{{ asset('storage/img_fitnesscourse/' . $firstDetail->fitnessCourse->img) }}"
                        alt="{{ $firstDetail->fitnessCourse->name }}" width="100">
                    <p><b>Course:</b> {{ $firstDetail->fitnessCourse->name }}</p>
                @else
                    <p><i>ไม่มีข้อมูลสินค้า/คอร์ส</i></p>
                @endif
            @endif

            <p><b>Total:</b>
                {{
                    $order->orderDetails->sum(function ($d) {
                        if ($d->product_id && $d->product) {
                            return $d->quantity * $d->product->price;
                        } elseif ($d->fitnesscourse_id && $d->fitnessCourse) {
                            return $d->quantity * $d->fitnessCourse->price;
                        }
                        return 0;
                    })
                }}
            </p>

            <p><b>Status:</b> {{ $order->status }}</p>

            <a href="{{ route('order.view-detail', ['orderCode' => $order->code]) }}">View Details</a>
        </div>
    @endforeach

    <div class="pagination">
        {{ $orders->links() }}
    </div>
@endsection
