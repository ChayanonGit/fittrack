@extends('products.main')

@section('content')
<form action="{{ route('products.create') }}" method="post" enctype="multipart/form-data">
    @csrf

    <label for="app-inp-code">Image</label>
<div class="upload-box">
    <input type="file" id="img-upload" name="img" accept="image/*">
    <label for="img-upload" class="upload-btn">
        <i class="fa-solid fa-image"></i> เลือกรูปภาพ
    </label>
    <span id="file-name">ยังไม่ได้เลือกรูป</span>
</div>
        <label for="app-inp-code">Code</label>
        <input type="text" id="app-inp-code" name="code" value="" required />

        <label for="app-inp-name">Name</label>
        <input type="text" id="app-inp-name" name="name" value="" required />

        <label for="app-inp-description">Category</label>
        <select name="category" id="">
            <option value="" selected>---Please Select---</option>
            @foreach($category as $cate)
            <option value="{{$cate->code}}" @selected($cate->code === old('category')) >{{$cate->code}}  {{$cate->name}}</option>
            @endforeach
        </select>

        <label for="app-inp-price">Price</label>
        <input type="number" id="app-inp-price" name="price" step="any" value="" required />

        <label for="app-inp-price">Qty</label>
        <input type="number" id="app-inp-price" name="stock" step="any" value="" required />

    </div>

    <div class="app-cmp-form-actions">
        <button type="submit">Create</button>

        <a href="{{ session()->get('bookmarks.products.create-form',route('products.list')) }}"><button type="button">Cancel</button>
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