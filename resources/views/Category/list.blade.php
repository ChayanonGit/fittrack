@extends('layouts.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/cate.css') }}">

    <!-- Search Form -->



    <!-- Pagination -->
    <div class="app-cmp-pagination">
        {{-- เพิ่ม appends(['term' => ...]) เพื่อให้ค่า search ไม่หายเวลาเปลี่ยนหน้า --}}
        {{ $category->appends(['term' => $criteria['term'] ?? ''])->links() }}
    </div>
    </div>
@endsection

@section('content')
    <div class="category-header">
        <div>
            <a href="{{ route('category.create') }}" class="new-class-btn">+ New Category</a>
            <h2>Category</h2>
        </div>

        <div>
            <search>
                <form action="{{ route('category.list') }}" method="get" class="app-cmp-search-form">
                    <input type="text" name="term" value="{{ $criteria['term'] ?? '' }}" placeholder="Search..." />
                    <button type="submit" class="app-cl-primary app-cl-filled">
                        <i class="material-symbols-outlined">search</i>
                    </button>
                    <a href="{{ route('category.reset') }}" class="app-cl-warn app-cl-filled">
                        <i class="material-symbols-outlined">X</i>
                    </a>

                </form>
            </search>
        </div>
    </div>


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
                            <a href="{{ route('category.view-product', ['category' => $categorys->code]) }}">Detail</a>
                            <a href="{{ route('category.update-form', ['category' => $categorys->code]) }}">Edit</a>
                            <a href="{{ route('category.delete', ['category' => $categorys->code]) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



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
                            <a href="{{ route('category.view-product', ['category' => $categorys->code]) }}"><i
                                    class="fa-solid fa-circle-info"></i></a>
                            <a href="{{ route('category.update-form', ['category' => $categorys->code]) }}"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
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
