@extends('products.main')

@section('content')
    <form action="{{ route('products.update', [
        'product' => $product->code,
    ]) }}" method="post">
        @csrf

        <div class="app-cmp-form-detail">
            <label for="app-inp-code">Code</label>
            <input type="text" id="app-inp-code" name="code" value="{{( $product->code) }}" required />

            <label for="app-inp-name">Name</label>
            <input type="text" id="app-inp-name" name="name" value="{{( $product->name) }}" required />

            <label for="app-inp-description">Category</label>
            <select name="category" id="">
                <option value="" selected>---Please Select---</option>
                @foreach ($category as $cate)
                    <option value="{{ $cate->code }}" @selected($cate->code === old('category', $product->category->code))
                        @if ($product->category->code === $cate->code) selected @endif>
                        [{{ $cate->code }}] {{ $cate->name }}</option>
                @endforeach
            </select>

            <label for="app-inp-price">Price</label>
            <input type="number" id="app-inp-price" name="price" step="any" value="{{( $product->price) }}" required />

            <label for="app-inp-price">Qty</label>
            <input type="number" id="app-inp-price" name="stock" step="any" value="{{( $product->stock) }}" required />

        </div>

        <div class="app-cmp-form-actions">
            <button type="submit">Update</button>
            <a
                href="{{ route('products.list', [
                    'product' => $product->code,
                ]) }}"><button
                    type="button">Cancel</button></a>
        </div>
    </form>
@endsection
