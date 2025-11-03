@extends('shop.main')

@section('header')
@endsection

@section('content')
    {{-- shop panel: categories (horizontal) + products (grid) --}}
    <section class="shop-panel container">

        {{-- Shop by category (horizontal strip) --}}

        <div class="shop-by-category-wrap container">
            <div class="section-intro">
                <div class="intro-left">
                    <h2>Shop By Category</h2>

                </div>

            </div>

            <div class="shop-by-category">
                @foreach ($categories as $cate)
                    <a href="{{ route('category.view-product', $cate->code) }}" class="category-tile">
                        <div class="tile-media">
                            @if ($cate->img && file_exists(storage_path('app/public/img_cat/' . $cate->img)))
                                <img src="{{ asset('storage/img_cat/' . $cate->img) }}" alt="{{ $cate->name }}">
                            @else
                                <div class="tile-media placeholder"></div>
                            @endif
                        </div>

                        <div class="tile-caption">
                            <div class="tile-title">{{ $cate->name ?? 'No Category' }}</div>
                            <div class="tile-arrow">→</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- All products inside same visual panel --}}
        <div class="shop-products">
            <div class="section-intro">
                <div class="intro-left">
                    <h2>All Products</h2>
                    <p class="muted">สินค้าทั้งหมด</p>
                </div>
                <div class="intro-right">
                    <search>
                        <form action="{{ route('shop.view-shop') }}" method="get" class="app-cmp-search-form">
                            <div class="app-cmp-form-detail">
                                <label for="app-criteria-term">Search</label>
                                <input type="text" id="app-criteria-term" name="term"
                                    value="{{ $criteria['term'] }}" />


                            </div>

                            <div class="app-cmp-form-actions">
                                <a href="{{ route('shop.view-shop') }}">
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
                </div>
            </div>

            <div class="products-grid">
                @foreach ($shop as $shops)
                    <article class="product-card">
                        <div class="product-media">
                            @if ($shops->img && file_exists(storage_path('app/public/img_product/' . $shops->img)))
                                <img src="{{ asset('storage/img_product/' . $shops->img) }}" alt="{{ $shops->name }}">
                            @else
                                <div class="product-media placeholder"></div>
                            @endif
                        </div>

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
            </div>
        </div>
    </section>
@endsection
