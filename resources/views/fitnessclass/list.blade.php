@extends('fitnessclass.main')

@section('header')
@endsection

@section('content')
    Product Category<br>
    <a href="{{ route('fitnessclass.create-class') }}">New Class</a>

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
                        <td>{{ $classes->description}}</td>
                        <td>
                            <a href="{{ route('fitnessclass.update-class', ['class' => $classes->code]) }}">Edit</a>
                            <a href="{{ route('fitnessclass.delete', ['class' => $classes->code]) }}">Delete</a>
                        </td>
                    </tr>
                    
                @endforeach
            </tbody>
        </table>

    </div>
@endsection
