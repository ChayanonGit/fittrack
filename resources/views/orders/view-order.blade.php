@extends('orders.main')

@section('header')
@endsection

@section('content')
<<<<<<< HEAD
    Order List<br>
=======

    <h2>Order List<br>
    
    {{-- <a href="{{ route('shop.view-shop') }}">Shop</a> --}}
>>>>>>> origin/uxui12

    <div class="pd-data-list">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Desc</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td colspan="5">
                            <div class="order-summary">
                                <p>Order #{{ $order->code }}</p>
                                <p>Order Status: {{ $order->status }}</p>

                                @foreach ($order->orderDetails as $detail)
                                    @php
                                        // เลือก item ไม่ว่าจะเป็น product หรือ fitnessCourse
                                        $item = $detail->product ?? $detail->fitnessCourse;
                                    @endphp

                                    @if ($item)
                                        <div class="order-item">
                                            <img src="{{ asset('storage/img_product/' . ($item->img ?? 'default.png')) }}"
                                                alt="{{ $item->name ?? 'No Name' }}" width="100">
                                            <p>Name: {{ $item->name ?? 'Unnamed' }}</p>
                                            <p>Quantity: {{ $detail->quantity }}</p>
                                            <p>Price: {{ number_format($detail->price, 2) }}</p>
                                        </div>
                                    @else
                                        <p>No item data available</p>
                                    @endif
                                @endforeach

                                <p>Total:
                                    {{ $order->orderDetails->sum(fn($d) => $d->quantity * ($d->product->price ?? ($d->fitnessCourse->price ?? 0))) }}
                                </p>

                                <a href="{{ route('admin.order.view-detail', ['orderCode' => $order->code]) }}">
                                    View Details<i class="fa-solid fa-circle-info"></i>
                                </a>
                                @if ($order->status == 'paid')
                                    <a href="{{ route('admin.order.delete', ['orderCode' => $order->code]) }}"><i class="fa-solid fa-trash"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No Orders Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection
