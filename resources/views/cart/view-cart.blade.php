@extends('cart.main')

@section('header')
@endsection

@section('content')
    <h2>ตะกร้าสินค้า</h2>

    @if (session('cart'))
        <table>
            <tr>
                <th>สินค้า</th>
                <th>ราคา</th>
                <th>จำนวน</th>
                <th>รวม</th>
                <th>ลบ</th>
            </tr>
            @foreach ($cart as $code => $item)
                <tr data-code="{{ $code }}" data-type="{{ $item['type'] ?? 'product' }}">
                    <td>
                        <img src="{{ asset('storage/img_product/' . ($item['img'] ?? 'default.png')) }}"
                            alt="{{ $item['name'] }}" width="100">
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td class="price">{{ number_format($item['price']) }}</td>
                    <td>
                        <input type="number" class="quantity" value="{{ $item['quantity'] }}" min="1"
                            style="width:50px;">
                    </td>
                    <td class="total">{{ number_format($item['price'] * $item['quantity']) }}</td>
                    <td><a href="{{ route('cart.remove', $code) }}">ลบ</a></td>
                </tr>
            @endforeach

            <p>รวมทั้งหมด: <span id="grand-total">{{ number_format($grandTotal) }}</span></p>





        </table>
    @else
        <p>ยังไม่มีสินค้าในตะกร้า</p>
    @endif


    <form action="{{ route('cart.checkout', ['CartCode' => $cart]) }}" method="POST">
        @csrf
        <button type="submit">Checkout</button>
    </form>


    <button>cancel</button>
@endsection



@section('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
@endsection
