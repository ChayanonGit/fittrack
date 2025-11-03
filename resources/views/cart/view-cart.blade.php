@extends('cart.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
<div class="cart-container">
    <div class="cart-items">
        <h2>ตะกร้าสินค้า</h2>

        @if (session('cart'))
            <table>
                <tr>
                    <th>สินค้า</th>
                    <th>ชื่อ</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th>รวม</th>
                    <th>ลบ</th>
                </tr>

                @foreach ($cart as $code => $item)
                    <tr>
                        <td>
                            <img src="{{ asset('storage/img_product/' . ($item['img'] ?? 'default.png')) }}" alt="{{ $item['name'] }}">
                        </td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ number_format($item['price']) }}</td>
                        <td><input type="number" class="quantity" value="{{ $item['quantity'] }}" min="1"></td>
                        <td>{{ number_format($item['price'] * $item['quantity']) }}</td>
                        <td><a href="{{ route('cart.remove', $code) }}">ลบ</a></td>
                    </tr>
                @endforeach
            </table>
        @else
            <p>ยังไม่มีสินค้าในตะกร้า</p>
        @endif
    </div>

    <div class="cart-summary">
        <h3>สรุปการสั่งซื้อ</h3>
        <div class="summary-line">
            <span>ยอดรวม</span>
            <span>{{ number_format($grandTotal) }} ฿</span>
        </div>

        <div class="summary-total">
            <span>Total</span>
            <span>{{ number_format($grandTotal) }} ฿</span>
        </div>

        <form action="{{ route('cart.checkout', ['CartCode' => $cart]) }}" method="POST">
            @csrf
            <button type="submit" class="checkout-btn">Checkout</button>
        </form>
        <button class="cancel-btn">Cancel</button>
    </div>
</div>
@endsection