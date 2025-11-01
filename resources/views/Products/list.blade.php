@extends('products.main')

@section('header')
@endsection

@section('content')
    Product List<br>
    <a href="{{ route('products.create-form') }}">Add Product</a>

    <div class="pd-data-list">
        <table>
            <thead>

                <tr>Image</tr>
                <tr>Name</tr>
                <tr>Desc</tr>
                <tr>Stock</tr>

            </thead>
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

                        <td>

                        <td><a href="{{ route('products.delete', ['product' => $products->code]) }}">delete</a></td> --
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endsection
