@extends('category.main')

@section('content')
    <form action="{{ route('category.create') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="">
            <b>Code</b>
            <input type="text" name="code" value="{{ old('code') }}" required>
        </label><br>

        <label for="">
            <b>Name</b>
            <input type="text" name="name"value="{{ old('name') }}" required>
        </label><br>


        <label for="">
            <b>Description</b>
            <textarea name="description" id="" required cols="80" rows="10">{{ old('description') }}</textarea>
        </label><br>

        <label for="">
            <b>Discount</b>
            <input type="price" value="{{ old('discount') }}">
        </label><br>
        <label>
            <b>Category Images</b>
            <input type="file" accept="image/*" name="img">


        </label>
        @error('images')
            <div style="color:red">{{ $message }}</div>
        @enderror
        <div class="app-cmp-form-actions">
            <button type="submit">Create</button>

            <a href=""><button type="button">Cancel</button>
            </a>

        </div>
    </form>
@endsection
