@extends('orders.main')

@section('content')
    <h1 class="page-title">Product List</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('shop.view-shop') }}"> Shop</a>
    </div>

    @foreach ($orders as $order)
        <div class="order-summary">
            <p><strong>Order #{{ $order->code }}</strong></p>

            @php
                $firstDetail = $order->orderDetails->first();
            @endphp

            @if ($firstDetail)
                <img src="{{ asset('storage/img_product/' . $firstDetail->product->img) }}"
                     alt="{{ $firstDetail->product->name }}" width="100">
                <p><b>Product:</b> {{ $firstDetail->product->name }}</p>
            @endif

            <p><b>Total:</b>
                {{ $order->orderDetails->sum(fn($d) => $d->quantity * $firstDetail->product->price) }}
            </p>

            <p><b>Status:</b> {{ $order->status }}</p>

            <a href="{{ route('order.view-detail', ['orderCode' => $order->code]) }}">View Details</a>
        </div>
    @endforeach

    <div class="pagination">
        {{ $orders->links() }}
    </div>
@endsection