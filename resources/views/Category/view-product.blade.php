@extends('Category.main')

@section('header')
    {{-- เชื่อมไฟล์ CSS เข้ากับหน้า --}}
    <link rel="stylesheet" href="{{ asset('css/category.css') }}">
@endsection

@section('content')
<div class="category-container">
   <h2>Product Category<br>
       <a href="{{ route('products.create') }}" class="new-category">New Product</a>
   </h2>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if ($category->img)
                            <img src="{{ asset('storage/img_cat/' . $category->img) }}" alt="{{ $category->name }}">
                        @endif
                    </td>
                    <td>{{ $category->code }}</td>
                    <td>{{ $category->name }}</td>
                </tr>

                @foreach ($product as $products)
                    <tr>
                        <td>
                            @if ($products->img)
                                <img src="{{ asset('storage/img_product/' . $products->img) }}" alt="{{ $products->name }}">
                            @endif
                        </td>
                        <td>{{ $products->code }}</td>
                        <td>{{ $products->name }}</td>
                        <td>{{ $products->stock ?? '-' }}</td>
                        <td class="action-links">
                            <a href="{{ route('products.update-form', ['product' => $products->code, 'from_category' => $category->code]) }}">Edit</a>
                            <a href="{{ route('products.delete', ['product' => $products->code, 'from_category' => $category->code]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection