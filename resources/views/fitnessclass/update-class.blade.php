@extends('fitnessclass.main')

@section('content')
    <form action="{{ route('fitnessclass.update', [
        'class' => $class->code,
    ]) }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <label for="">
            <b>Code</b>
            <input type="text" name="code" value="{{ $class->code }}" required />
        </label><br>

        <label for="">
            <b>Name</b>
            <input type="text" name="name" value="{{ $class->name }}" required />
        </label><br>
        <label for="">
            <b>Price</b>
            <input type="text" name="name" value="{{ $class->price }}" required />
        </label><br>


        <label for="">
            <b>Description</b>
            <textarea name="description" id="" require cols="80" rows="10">{{ $class->description }}</textarea>
        </label><br>
        <b>Category Images</b><br>
        @if ($class->img)
            <img src="{{ asset('storage/img_cat/' . $class->img) }}" alt="{{ $class->name }}" width="100">
        @endif
        <input type="file" accept="image/*" name="img">
        <div class="app-cmp-form-actions">
            <button type="submit">Update</button>
            <a href="{{ route('fitnessclass.list', [
                'class' => $class->code,
            ]) }}"><button
                    type="button">Cancel</button></a>
        </div>
    </form>
@endsection
