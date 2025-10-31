@extends('products.main')

@section('content')
<form action="{{ route('products.create') }}" method="post">
    @csrf

    <div class="app-cmp-form-detail">
        <label for="app-inp-code">Image</label>
        <input type="file" accept="image/*" id="input-file" value="" name="img">

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