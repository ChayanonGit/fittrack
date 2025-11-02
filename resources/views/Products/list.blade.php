@extends('layouts.main')

@section('header')
@endsection

@section('content')
<section class="category-list container">
	{{-- header with add button --}}
	<div class="section-intro" style="padding:6px 0;">
		<div class="intro-left">
			<h2 class="category-list-title">Products</h2>
		</div>
		<div class="intro-right">
			<a href="{{ route('products.create') }}" class="btn-cta">เพิ่มสินค้า</a>
		</div>
	</div>

	<div class="category-grid">
		@foreach($products as $product)
			<article class="category-card">
				<div class="category-media">
					@if($product->img && file_exists(storage_path('app/public/img_product/' . $product->img)))
						<img src="{{ asset('storage/img_product/' . $product->img) }}" alt="{{ $product->name }}">
					@else
						<div class="category-placeholder"></div>
					@endif
				</div>

				<div class="category-meta">
					<h3 class="category-name">{{ $product->name }}</h3>
					<p class="category-desc">{{ Str::limit($product->description ?? '', 100) }}</p>
					<p class="product-price">฿{{ number_format($product->price ?? 0, 2) }}</p>
				</div>

				<div class="category-actions">
					<a href="{{ route('products.list', $product->code) }}" class="btn-view">View</a>
            </thead>
            <tbody>
            </tbody>
            <tbody>
                <tr>
                    @foreach ($products as $products)
                        @if ($products->img)
                            <img src="{{ asset('storage/img_product/' . $products->img) }}" alt="{{ $products->name }}"
                                width="100">
                        @endif
                        <td>{{ $products->name }}</td>
                        <td>{{ $products->price }}</td>
                        <td>{{ $products->stock }}</td>
                        <td><a href="{{ route('products.update-form', ['product' => $products->code]) }}">Edit</a>

					<a href="{{ route('products.update-form', ['product' => $product->code]) }}" class="btn-edit">Edit</a>

					
                    <a href="{{ route('products.delete', ['product'=>$product->code]) }}" class="btn-delete">Delete</a>
				</div>
			</article>
		@endforeach
	</div>	
</section>
@endsection
