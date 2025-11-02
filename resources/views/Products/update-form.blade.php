@extends('products.main')

@section('content')
<div class="update-container">
    <h2 class="update-title">Update Product</h2>

    <form action="{{ route('products.update', ['product' => $product->code]) }}" method="post">
        @csrf
        <input type="hidden" name="from_category" value="{{ $fromCategory }}">

        <div class="app-cmp-form-detail">
            <div class="form-group">
                <label for="app-inp-code">Code</label>
                <input type="text" id="app-inp-code" name="code" value="{{ $product->code }}" required />
            </div>

            <div class="form-group">
                <label for="app-inp-name">Name</label>
                <input type="text" id="app-inp-name" name="name" value="{{ $product->name }}" required />
            </div>

            <div class="form-group">
                <label for="app-inp-description">Category</label>
                <select name="category" id="app-inp-description">
                    <option value="" selected>---Please Select---</option>
                    @foreach ($category as $cate)
                        <option value="{{ $cate->code }}" 
                            @selected($cate->code === old('category', $product->category->code))>
                            [{{ $cate->code }}] {{ $cate->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="app-inp-price">Price</label>
                <input type="number" id="app-inp-price" name="price" step="any" value="{{ $product->price }}" required />
            </div>

            <div class="form-group">
                <label for="app-inp-stock">Qty</label>
                <input type="number" id="app-inp-stock" name="stock" step="any" value="{{ $product->stock }}" required />
            </div>
        </div>

        <div class="app-cmp-form-actions">
            <button type="submit" class="btn-update">Update</button>
            <a href="{{ route('products.list', ['product' => $product->code]) }}">
                <button type="button" class="btn-cancel">Cancel</button>
            </a>
        </div>
    </form>

    <div class="footer">© FROM FITTRACK</div>
</div>
@endsection