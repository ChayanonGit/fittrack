@extends('shop.main')

@section('header')
@endsection

@section('content')
    @foreach ($class as $classes)
        <div>
            @if ($classes->img)
                <img src="{{ asset('storage/img_cat/' . $classes->img) }}" alt="{{ $classes->name }}" width="100">
            @endif
            {{ $classes->name }}
            {{ $classes->price }} บาท
            (คงเหลือ {{ $classes->stock }})
            <form action="{{ route('cart.add', $classes->code) }}" method="POST">
                @csrf
                <button type="submit">Add to cart</button>
            </form>


        </div>
    @endforeach
@endsection

@section('scripts')
<script>
    // เอาปุ่ม "ลงทะเบียน" ออกเมื่อหน้าโหลด (รองรับกรณีเป็นปุ่มหรือลิงก์ และกรณีมี class .ft-register-btn)
    (function(){
        document.addEventListener('DOMContentLoaded', function(){
            // เอาตาม class ถ้ามี
            document.querySelectorAll('.ft-register-btn').forEach(function(el){
                el.remove();
            });
            // ถ้าไม่มี class ให้ค้นหาจากข้อความปุ่ม/ลิงก์
            document.querySelectorAll('button, a').forEach(function(el){
                if(el.textContent && el.textContent.trim() === 'ลงทะเบียน'){
                    el.remove();
                }
            });
        });
    })();
</script>
@endsection
