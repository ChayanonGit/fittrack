@extends('category.main', [
    'title' => $category->code,
])

@section('content')
    <form action="{{ route('category.update', [
        'category' => $category->code,
    ]) }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <label for="">
            <b>Code</b>
            <input type="text" name="code" value="{{ $category->code }}" required />
        </label><br>

        <label for="">
            <b>Name</b>
            <input type="text" name="name" value="{{ $category->name }}" required />
        </label><br>


        <label for="">
            <b>Description</b>
            <textarea name="description" id="" require cols="80" rows="10">{{ $category->description }}</textarea>
        </label><br>
        <b>Category Images</b><br>
        @if ($category->img)
            <img src="{{ asset('storage/img_cat/' . $category->img) }}" alt="{{ $category->name }}" width="100">
        @endif
        <input type="file" accept="image/*" name="img">
        <div class="app-cmp-form-actions">
            <button type="submit">Update</button>
            <a href="{{ route('category.list', [
                'category' => $category->code,
            ]) }}"><button
                    type="button">Cancel</button></a>
        </div>
    </form>
@endsection
