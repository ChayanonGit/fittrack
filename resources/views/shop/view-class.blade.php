@extends('shop.main')

@section('header')
@endsection

@section('content')
    @foreach ($class as $classes)
        <div>
            @if ($classes->img)
                <img src="{{ asset('storage/img_cat/' . $classes->img) }}" alt="{{ $classes->name }}" width="100">
            @endif
            {{ $classes->name }}
            {{ $classes->price }} บาท
            (คงเหลือ {{ $classes->stock }})
            <form action="{{ route('cart.add', $classes->code) }}" method="POST">
                @csrf
                <button type="submit">Add to cart</button>
            </form>


        </div>
    @endforeach
@endsection
