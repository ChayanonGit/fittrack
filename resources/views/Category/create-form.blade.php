@extends('category.main')

@section('content')
    <a class="TA"><form action="{{ route('category.create') }}" method="post" enctype="multipart/form-data">
        @csrf

        <label for="">
            <b>Code</b>
            <input type="text" name="code" value="{{ old('code') }}" required>
        </label><br>

        <label for="">
            <b>Name</b>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </label><br>

        <label for="">
            <b>Description</b>
            <textarea name="description" id="" required cols="80" rows="10">{{ old('description') }}</textarea>
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

            {{-- ปุ่ม Cancel กลับหน้าก่อนหน้า --}}
            <a href="{{ url()->previous() }}">
                <button type="button" class="cancel">Cancel</button>
            </a>
        </div>
    </form>
@endsection
