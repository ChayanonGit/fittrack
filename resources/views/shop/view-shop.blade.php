@extends('shop.main')

@section('header')
@endsection

@section('content')
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
