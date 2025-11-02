@extends('layouts.main')

@section('header')
	<link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">
@endsection

@section('content')
	<h2>Products</h2>
	<a href="{{ route('products.create') }}" class="new-class-btn">+ New Product</a>

	<div class="cg-data-list">
		<table>
			<thead>
				<tr>
					<th>Image</th>
					<th>Code</th>
					<th>Name</th>
					<th>Price</th>
					<th>Stock</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($products as $product)
					<tr>
						<td>
							@if ($product->img)
								<img src="{{ asset('storage/img_product/' . $product->img) }}" alt="{{ $product->name }}" width="100">
							@else
								<div style=""></div>
							@endif
						</td>
						<td>{{ $product->code }}</td>
						<td>{{ $product->name }}</td>
						<td>{{ number_format($product->price ?? 0, 2) }}</td>
						<td>{{ $product->stock }}</td>
						<td>
							<a href="{{ route('products.update-form', ['product' => $product->code]) }}">Edit</a>
							<a href="{{ route('products.delete', ['product' => $product->code]) }}">Delete</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

    
        <div class="category-grid">
            @foreach ($products as $product)
                <article class="category-card">
                    <div class="category-media">
                        @if ($product->img)
                            <img src="{{ asset('storage/img_product/' . $product->img) }}" alt="{{ $product->name }}"
                                width="100">
                        @endif
                    </div>

                    <div class="category-meta">
                        <h3 class="category-name">{{ $product->name }}</h3>
                        <p class="product-price">฿{{ number_format($product->price ?? 0, 2) }}</p>
                        <p class="product-stock">{{ $product->stock }}</p>
                    </div>

                    <div class="category-actions">

                        <a href="{{ route('products.update-form', ['product' => $product->code]) }}"
                            class="btn-edit">Edit</a>
                        <a href="{{ route('products.delete', ['product' => $product->code]) }}" class="btn-delete"
                            data-name="{{ $product->name }}">
                            Delete
                        </a>






                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
