@extends('Category.main')

@section('header')
@endsection

@section('content')
    Product Category<br>
    <a href="{{ route('category.create-form') }}">New Category</a>

    <div class="cg-data-list">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Desc</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($category as $categorys)
                    <tr>
                        <td>
                            @if ($categorys->img)
                                <img src="{{ asset('storage/img_cat/' . $categorys->img) }}" alt="{{ $categorys->name }}"
                                    width="100">
                            @endif
                        </td>
                        <td>{{ $categorys->code }}</td>
                        <td>{{ $categorys->name }}</td>
                        <td>{{ $categorys->description }}</td>
                        <td>{{ $categorys->stock ?? '-' }}</td>
                        <td>
                            <a href="{{ route('category.update-form', ['category' => $categorys->code]) }}">Edit</a>
                            <a href="{{ route('category.delete', ['category' => $categorys->code]) }}">Delete</a>
                            <a href="{{ route('category.view-product', ['category' => $categorys->code]) }}">View Product</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
