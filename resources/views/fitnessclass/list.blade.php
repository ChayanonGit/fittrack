@extends('fitnessclass.main')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/fitnessclass.css') }}">
    <search>
        <form action="{{ route('fitnessclass.list') }}" method="get" class="app-cmp-search-form">
            <div class="app-cmp-form-detail">
                <label for="app-criteria-term">Search</label>
                <input type="text" id="app-criteria-term" name="term" value="{{ $criteria['term'] }}" />

                
            </div>

            <div class="app-cmp-form-actions">
                <a href="{{ route('fitnessclass.list') }}">
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

    
@endsection

@section('content')
    <h2>Fitness Class</h2>
    <a href="{{ route('fitnessclass.create-class') }}" class="new-class-btn">+ New Class</a>

    <div class="cg-data-list">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Desc.</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($class as $classes)
                    <tr>
                        <td>
                            @if ($classes->img)
                                <img src="{{ asset('storage/img_cat/' . $classes->img) }}" alt="{{ $classes->name }}"
                                    width="100">
                            @endif
                        </td>
                        <td>{{ $classes->code }}</td>
                        <td>{{ $classes->name }}</td>
                        <td>{{ $classes->price }}</td>
                        <td>{{ $classes->description }}</td>
                        <td>
                            <a href="{{ route('fitnessclass.update-class', ['class' => $classes->code]) }}"><i class="fa-solid fa-pen-to-square"></i></a>

                            <a href="{{ route('fitnessclass.delete', ['class' => $classes->code]) }}" class="btn-delete"
                                data-name="{{ $classes->name }}">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
