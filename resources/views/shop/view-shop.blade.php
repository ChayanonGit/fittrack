@extends('shop.main')

@section('header')
@endsection

@section('content')
	{{-- shop grid --}}
	<section class="shop-grid container">
		@foreach ($shop as $shops)
			<article class="product-card">
				<div class="product-media">
					@if ($shops->img && file_exists(storage_path('app/public/img_product/' . $shops->img)))
						<img src="{{ asset('storage/img_product/' . $shops->img) }}" alt="{{ $shops->name }}">
					@else
						<div class="product-media placeholder">
							{{-- placeholder (red background) shown when no image --}}
						</div>
					@endif
				</div>
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

				<div class="product-meta">
					<div class="product-name">{{ $shops->name }}</div>
					<div class="product-price">฿{{ number_format($shops->price, 2) }}</div>
				</div>

				<div class="product-actions">
					<form action="{{ route('cart.add', $shops->code) }}" method="POST" class="product-add-form">
						@csrf
						<button type="submit" class="btn-add">Add to cart</button>
					</form>
				</div>
			</article>
		@endforeach
	</section>
@endsection
