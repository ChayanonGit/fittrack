@extends('orderlist.main')

@section('header')
@endsection

@section('content')
    <h2>Order #{{ $order->id }}</h2>
    <p>User: {{ $order->user_id }}</p>

    <table>
        <thead>
            <tr>
                <td><img src="{{ asset('storage/img_product/' . $detail->product->img) }}"
                        alt="{{ $detail->product->name }}" width="100"></td>

                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ $detail->product->price }}</td>
                <td>{{ $detail->quantity * $detail->product->price }}</td>


            </tr>
        @endforeach
        <td><a href="{{ route('order.delete', ['orderCode' => $order->code]) }}">Cancel</a></td>


                </tr>
            @endforeach
            <td><a href="{{ route('order.delete', ['orderCode' => $order->code]) }}">Cancel</a></td>

        </tbody>
    </table>

    <p>Total: {{ $order->orderDetails->sum(fn($d) => $d->quantity * $d->product->price) }}</p>
@endsection
