@extends('layouts.main')

@section('header')
	<link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">

    <search>
        <form action="{{ route('products.list') }}" method="get" class="app-cmp-search-form">
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />

                
            </div>

            <div class="app-cmp-form-actions">
                <a href="{{ route('products.list') }}">
                    <button type="button" class="app-cl-warn app-cl-filled">
                        <i class="material-symbols-outlined">close</i>
                    </button>
                </a>
                <button type="submit" class="app-cl-primary app-cl-filled">
                    <i class="material-symbols-outlined">search</i>
                </button>
            </div>
        </form>
    </search>

    <div class="app-cmp-links-bar">
        <nav>
            @php
                session()->put('bookmarks.products.create-form', url()->full());
            @endphp

            <ul class="app-cmp-links">
                @can('create', \App\Models\Product::class)
                    <li class="app-cl-filled">
                        <a href="{{ route('products.create-form') }}">
                            <i class="material-symbols-outlined">add_box</i>
                            New Product
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>

        {{ $products->withQueryString()->links() }}
    </div>
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

    
       
    </section>
@endsection
