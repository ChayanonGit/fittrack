@extends('fitnessclass.main')

@section('content')
<form action="{{ route('fitnessclass.create') }}" method="post" enctype="multipart/form-data">
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
        <b>price</b>
        <input type="price" name="price" value="{{ old('price') }}" required>
    </label><br>


    <label for="">
        <b>Description</b>
        <textarea name="description" id="" required cols="80" rows="10">{{ old('description') }}</textarea>
    </label><br>


    <label>
        <b>Category Images</b>
        <div class="upload-box">
            <input type="file" id="img-upload" name="img" accept="image/*">
            <label for="img-upload" class="upload-btn">
                <i class="fa-solid fa-image"></i> เลือกรูปภาพ
            </label>
            <span id="file-name">ยังไม่ได้เลือกรูป</span>
        </div>
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
@section('scripts')
<script>
    document.getElementById('img-upload').addEventListener('change', function() {
        const fileName = this.files.length > 0 ? this.files[0].name : 'ยังไม่ได้เลือกรูป';
        document.getElementById('file-name').textContent = fileName;
    });
</script>
@endsection