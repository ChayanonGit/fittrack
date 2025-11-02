@extends('layouts.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">
@endsection

@section('content')
    <h2>Product Category</h2>
    <a href="{{ route('products.create') }}" class="new-class-btn">+ NEW CLASS</a>

    <div class="cg-data-list">
        <table>
            <thead>
                <tr>
                    <th>IMAGE</th>
                    <th>CODE</th>
                    <th>NAME</th>
                    <th>PRICE</th>
                    <th>DESC.</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($product->img)
                                <img src="{{ asset('storage/img_product/' . $product->img) }}" alt="{{ $product->name }}"
                                    width="100">
                            @endif
                        </td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->price ?? 0, 2) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('products.update-form', ['product' => $product->code]) }}">EDIT</a>
                            <a href="{{ route('products.delete', ['product' => $product->code]) }}">DELETE</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
