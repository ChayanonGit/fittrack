@extends('layouts.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">
@endsection

@section('content')
    <h2>Product Category</h2>
    <a href="{{ route('products.create') }}" class="new-class-btn">+ NEW CLASS</a>

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
