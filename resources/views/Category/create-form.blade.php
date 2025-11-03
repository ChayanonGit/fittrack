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

        <label for="">
            <b>Discount</b>
            <input type="text" name="discount" value="{{ old('discount') }}">
        </label><br>

         <label for="app-inp-code">Image</label>
<div class="upload-box">
    <input type="file" id="img-upload" name="img" accept="image/*">
    <label for="img-upload" class="upload-btn">
        <i class="fa-solid fa-image"></i> เลือกรูปภาพ
    </label>
    <span id="file-name">ยังไม่ได้เลือกรูป</span>
</div>


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
@section('scripts')
<script>
document.getElementById('img-upload').addEventListener('change', function() {
    const fileName = this.files.length > 0 ? this.files[0].name : 'ยังไม่ได้เลือกรูป';
    document.getElementById('file-name').textContent = fileName;
});
</script>
@endsection
