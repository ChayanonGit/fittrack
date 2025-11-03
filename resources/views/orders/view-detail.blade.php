@extends('orderlist.main')

@section('header')
@endsection

@section('content')

    <h2>Order #{{ $order->code }}</h2>
    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                @php
                    // เลือกว่าจะเอา product หรือ fitnessCourse
                    $item = $detail->product ?? $detail->fitnessCourse;
                @endphp
                <tr>
                    <td>
                        @if($item)
                            <img src="{{ asset('storage/img_product/' . $item->img) }}"
                                 alt="{{ $item->name }}" width="100">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $item->name ?? 'N/A' }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $item->price ?? 0 }}</td>
                    <td>{{ $detail->quantity * ($item->price ?? 0) }}</td>
                </tr>
            @endforeach

            @if ($order->status !== 'paid')
                <tr>
                    <td colspan="5">
                        <a href="{{ route('admin.order.delete', ['orderCode' => $order->code]) }}">Cancel</a>

                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <p>Total: {{ $order->orderDetails->sum(fn($d) => $d->quantity * (($d->product ?? $d->fitnessCourse)?->price ?? 0)) }}</p>
@endsection
