@extends('orders.main')

@section('content')
    <h1 class="page-title">Product List</h1>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="{{ route('shop.view-shop') }}">Shop</a>
    </div>

    @foreach ($orders as $order)
        @php
            // กรองเฉพาะ orderDetails ที่มี product_id หรือ fitnesscourse_id
            $validDetails = $order->orderDetails->filter(function ($d) {
                return ($d->product_id && $d->product) || ($d->fitnesscourse_id && $d->fitnessCourse);
            });
        @endphp

        {{-- ถ้าไม่มีรายการที่ตรงเงื่อนไขเลย ข้ามออเดอร์นี้ไป --}}
        @if ($validDetails->isEmpty())
            @continue
        @endif

        <div class="order-summary">
            <p><strong>Order #{{ $order->code }}</strong></p>

            @php
                $firstDetail = $validDetails->first();
            @endphp

            @if ($firstDetail->product_id && $firstDetail->product)
                <img src="{{ asset('storage/img_product/' . $firstDetail->product->img) }}"
                    alt="{{ $firstDetail->product->name }}" width="100">
                <p><b>Product:</b> {{ $firstDetail->product->name }}</p>
            @elseif ($firstDetail->fitnesscourse_id && $firstDetail->fitnessCourse)
                <img src="{{ asset('storage/img_fitnesscourse/' . $firstDetail->fitnessCourse->img) }}"
                    alt="{{ $firstDetail->fitnessCourse->name }}" width="100">
                <p><b>Course:</b> {{ $firstDetail->fitnessCourse->name }}</p>
            @endif

            <p><b>Total:</b>
                {{
                    $validDetails->sum(function ($d) {
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
