@extends('layouts.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">
@endsection

@section('content')
    <h2>Category</h2>
    <a href="{{ route('category.create') }}" class="new-class-btn">+ New Category</a>

    <div class="cg-data-list">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Desc.</th>
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
                            @else
                                <div></div>
                            @endif
                        </td>
                        <td>{{ $categorys->code }}</td>
                        <td>{{ $categorys->name }}</td>
                        <td>{{ Str::limit($categorys->description ?? '', 100) }}</td>
                        <td>
                            <a href="{{ route('category.view-product', ['category' => $categorys->code]) }}"><i class="fa-solid fa-circle-info"></i></a>
                            <a href="{{ route('category.update-form', ['category' => $categorys->code]) }}"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="{{ route('category.delete', ['category' => $categorys->code]) }}" class="btn-delete"
                                data-name="{{ $categorys->name }}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    </section>
@endsection
