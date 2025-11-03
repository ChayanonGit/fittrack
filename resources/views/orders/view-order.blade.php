@extends('orders.main')

@section('header')
@endsection

@section('content')

    <h2>Order List<br>
    
    {{-- <a href="{{ route('shop.view-shop') }}">Shop</a> --}}

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

                    {{-- เช็คก่อนว่ามี product --}}

                    @foreach ($orders as $order)
                        <div class="order-summary">
                            @php
                                $firstDetail = $order->orderDetails->first();

                            @endphp
                            @if ($firstDetail&& $order->orderDetails->isNotEmpty())
                                <p>Order #{{ $order->code }}</p>
                                <p>Products:

                                    @if ($firstDetail)
                                        <img src="{{ asset('storage/img_product/' . $firstDetail->product->img) }}"
                                            alt="{{ $firstDetail->product->name }}" width="100">
                                    @endif

                                </p>
                                @if ($firstDetail)
                                    <p>Order Name:{{ $firstDetail->product->name }}</p>
                                @endif

                                <p>Total:
                                    {{ $order->orderDetails->sum(fn($d) => $d->quantity * $firstDetail->product->price) }}
                                </p>
                                <p>Order Status :{{ $order->status }}</p>

                                <a href="{{ route('admin.order.view-detail', ['orderCode' => $order->code]) }}">View
                                    Details</a>




                        </div>
                    @else
                    @endif
                    @endforeach
                    No Order
                    {{ $orders->links() }}


                </tr>
            </tbody>
        </table>
    </div>
@endsection
