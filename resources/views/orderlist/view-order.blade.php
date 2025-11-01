@extends('orderlist.main')

@section('header')
@endsection

@section('content')
    Product List<br>
    <a href="{{ route('products.create-form') }}">Add Product</a>

    <div class="pd-data-list">
        <table>
            <thead>

                <tr>Image</tr>
                <tr>Name</tr>
                <tr>Desc</tr>
                <tr>Stock</tr>

            </thead>
            <tbody>
                <tr>
                    @foreach ($orders as $order)
                        <div class="order-summary">
                            <p>Order #{{ $order->code }}</p>
                            <p>Products:
                                @php
                                    $firstDetail = $order->orderDetails->first();
                                @endphp

                                @if ($firstDetail)
                                    <img src="{{ asset('storage/img_product/' . $firstDetail->product->img) }}"
                                        alt="{{ $firstDetail->product->name }}" width="100">
                                @endif
                            </p>
                            @if ($firstDetail)
                                <p>Order Name:{{ $firstDetail->product->name }}</p>
                            @endif

                            <p>Total: {{ $order->orderDetails->sum(fn($d) => $d->quantity * $d->product->price) }}</p>
                            <p>Order Status :{{ $order->status }}</p>

                            <a href="{{ route('order.view-detail', ['orderCode' => $order->code]) }}">View Details</a>




                        </div>
                    @endforeach

                    {{ $orders->links() }}


                    {{ $orders->links() }}


                </tr>
            </tbody>
        </table>
    </div>
@endsection
