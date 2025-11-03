@extends('cart.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
<<<<<<< HEAD

    @if (session('cart') && count($cart) > 0)
        <div class="cart-wrapper">
            <div class="cart-container">
                <div class="cart-header-top">
                    <h2>ตะกร้าสินค้า</h2>
                </div>

                <!-- Left Side: Products -->
                <div class="cart-left">
                    <!-- Header -->
                    <div class="cart-header">
                        <div class="header-img">สินค้า</div>
                        <div class="header-name">ชื่อสินค้า</div>
                        <div class="header-price">ราคา</div>
                        <div class="header-quantity">จำนวน</div>
                        <div class="header-total">รวม</div>
                        <div class="header-remove">ลบ</div>
                    </div>

                    @foreach ($cart as $code => $item)
                        <div class="cart-item" data-code="{{ $code }}" data-type="{{ $item['type'] ?? 'product' }}">
                            <div class="item-img">
                                <img src="{{ asset('storage/img_product/' . ($item['img'] ?? 'default.png')) }}"
                                    alt="{{ $item['name'] }}" width="80">
                            </div>
                            <div class="item-name">{{ $item['name'] }}</div>
                            <div class="item-price">{{ number_format($item['price']) }}</div>
                            <div class="item-quantity">
                                <input type="number" class="quantity" value="{{ $item['quantity'] }}" min="1">
                            </div>
                            <div class="item-total">{{ number_format($item['price'] * $item['quantity']) }}</div>
                            <div class="item-remove">
                                <a href="{{ route('cart.remove', $code) }}">ลบ</a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right Side: Total & Checkout -->
                <div class="cart-right">
                    <h2>สรุปราคารวม</h2>
                    <p>รวมทั้งหมด: <span id="grand-total">{{ number_format($grandTotal) }}</span> ฿</p>

                    <form action="{{ route('cart.checkout', ['CartCode' => $cart]) }}" method="POST">
                        @csrf
                        <button type="submit" class="checkout-btn">Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <p>ยังไม่มีสินค้าในตะกร้า</p>
    @endif

@endsection

@section('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
=======
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
>>>>>>> origin/uxui12
