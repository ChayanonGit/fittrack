@extends('shop.main')

@section('header')
@endsection

@section('content')
    @foreach ($categories as $cate)
        <div class="product-card">
            <p>Category: {{ $cate->name ?? 'No Category' }}</p>

            @if ($cate->img)
                <img src="{{ asset('storage/img_cat/' . $cate->img) }}" alt="{{ $cate->name }}"
                    width="100">
            @endif
        </div>
    @endforeach

    @foreach ($shop as $shops)
        <div>
            @if ($shops->img)
                <img src="{{ asset('storage/img_product/' . $shops->img) }}" alt="{{ $shops->name }}" width="100">
            @endif
            {{ $shops->name }}
            {{ $shops->price }} บาท
            (คงเหลือ {{ $shops->stock }})
            <form action="{{ route('cart.add', $shops->code) }}" method="POST">
                @csrf
                <button type="submit">Add to cart</button>
            </form>


        </div>
    @endforeach
@endsection
