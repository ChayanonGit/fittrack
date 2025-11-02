@extends('Category.main')

@section('header')
    {{-- เชื่อมไฟล์ CSS เข้ากับหน้า --}}
    <link rel="stylesheet" href="{{ asset('css/category.css') }}">
@endsection

@section('content')
    Product Category<br>
    <a href="{{ route('products.create') }}">New Product</a>

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
                        <td>

                        <td><a
                                href="{{ route('products.update-form', ['product' => $products->code, 'from_category' => $category->code]) }}">Edit</a>

                            </form>
                            <a href="{{ route('products.delete', ['product' => $products->code, 'from_category' => $category->code]) }}" class="btn-delete"
                                data-name="{{ $products->name }}">
                                Delete
                            </a>
           
                               
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection