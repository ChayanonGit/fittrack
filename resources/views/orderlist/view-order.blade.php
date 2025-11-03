@extends('orders.main')
@section('header')
<link rel="stylesheet" href="{{ asset('css/pagination.css') }}">

@endsection
@section('content')
    <h1 class="page-title">Product List</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('shop.view-shop') }}">Shop</a>
    </div>

    @foreach ($orders as $order)
        <div class="order-summary">
            <p><strong>Order #{{ $order->code }}</strong></p>

            {{-- แสดงรายการสินค้าทั้งหมดในออเดอร์ --}}
            @foreach ($order->orderDetails as $detail)
                @php
                    // เลือก item ไม่ว่าจะเป็น product หรือ fitnessCourse
                    $item = $detail->product ?? $detail->fitnessCourse;
                @endphp

                @if ($item)
                    <div class="order-item" style="margin-bottom: 10px;">
                        <img src="{{ asset('storage/' . ($detail->product ? 'img_product/' : 'img_fitnesscourse/') . $item->img) }}"
                             alt="{{ $item->name }}" width="100">
                        <p><b>{{ $detail->product ? 'Product' : 'Course' }}:</b> {{ $item->name }}</p>
                        <p><b>Qty:</b> {{ $detail->quantity }}</p>
                        <p><b>Price:</b> {{ $item->price }}</p>
                    </div>
                @endif
            @endforeach

            {{-- รวมยอดทั้งหมด --}}
            @php
                $total = $order->orderDetails->sum(function ($d) {
                    $item = $d->product ?? $d->fitnessCourse;
                    return $item ? $d->quantity * $item->price : 0;
                });
            @endphp

            <p><b>Total:</b> {{ $total }}</p>
            <p><b>Status:</b> {{ $order->status }}</p>

            <a href="{{ route('order.view-detail', ['orderCode' => $order->code]) }}">View Details</a>
        </div>
    @endforeach

    <div class="pagination">
        {{ $orders->links() }}
    </div>
@endsection
