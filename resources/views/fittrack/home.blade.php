@extends('layouts.main')

@section('header')
@endsection

@section('content')

        <div class="box">
            <div class="slider">
                <div class="slides">
                    <input type="radio" name="radio-btn" id="radio1">
                    <input type="radio" name="radio-btn" id="radio2">
                    <input type="radio" name="radio-btn" id="radio3">


                    <div class="slide first">
                       <img src="{{ asset('storage/img_slide/s3.png') }}" alt="s3.png">


                    </div>
                    <div class="slide">
                        <img src="{{ asset('storage/img_slide/s2.jpg') }}"
                            alt="s2.png" >

                    </div>
                    <div class="slide">
                        <img src="{{ asset('storage/img_slide/s3.jpg') }}"
                            alt="s1.png" >

                    </div>



                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                    </div>


                    <div class="navigation-manual">
                        <label for="radio1" class="manual-btn"></label>
                        <label for="radio2" class="manual-btn"></label>
                        <label for="radio3" class="manual-btn"></label>
                    </div>

                </div>
            </div>
    <section class="section-intro container">
        <div class="intro-left">
            <h2>Movement Made Stylish.</h2>
            <p>Shop our best sellers.</p>
        </div>
        <div class="intro-right">
            <a class="btn-cta" href="{{ route('shop.view-shop') }}">SHOP ALL PRODUCTS</a>
        </div>
    </section>

    <section class="container">
        <div class="products-grid">
            <a href="{{ route('shop.view-shop') }}">
                <div class="product-card">
                    <div class="card-media"
                        style="background-image:url('https://sc04.alicdn.com/kf/H10b22a60bed64eb2a92f9739b8397f49m.jpg');">
                    </div>
                    <div class="card-title">Bracelet Weights </div>

                </div>
            </a>
            <a href="{{ route('shop.view-shop') }}">
                <div class="product-card">
                    <div class="card-media"
                        style="background-image:url('https://th-live.slatic.net/p/ff1ebdd3044f9506fcd91fe184478a6d.jpg');">
                    </div>
                    <div class="card-title">Exercise Ball</div>

                </div>
            </a>

            <a href="{{ route('shop.view-shop') }}">
                <div class="product-card">
                    <div class="card-media"
                        style="background-image:url('https://static.thairath.co.th/media/Dtbezn3nNUxytg04ajbQINgpa9ZDJFUvR6iZ9GEO8e9fKf.jpg');">
                    </div>
                    <div class="card-title">Hand Weights</div>

                </div>
            </a>
        </div>
    </section>

    <section class="section-intro container">


        <div class="intro-left">
            <h2>Our Best Fitness Class</h2>
            <p>Explore popular classes</p>
        </div>
        <div class="intro-right">
            <a class="btn-cta" href="{{ route('fitnessclass.list') }}">ALL FITNESS CLASS</a>
        </div>
    </section>
    <section class="container">
        <div class="products-grid">
            <a href="{{ route('fitnessclass.list') }}">
                <div class="product-card">
                    <div class="card-media"
                        style="background-image:url('https://news.thaipbs.or.th/media/2aYqS0l4EOhseuUiUeJuHGTZgsvx4LEv.jpg'); height:200px;">
                    </div>
                    <div class="card-title">Yoga Flow</div>

                </div>
            </a>

            <a href="{{ route('fitnessclass.list') }}">
                <div class="product-card">
                    <div class="card-media"
                        style="background-image:url('https://static.thairath.co.th/media/dFQROr7oWzulq5Fa4MLxHgPwY5hp4zj8OkUnvxFunQAcHWiYVRZrzkZrfyoMLWCIVlx.jpg'); height:200px;">
                    </div>
                    <div class="card-title">Strength Training</div>

                </div>
            </a>

            <a href="{{ route('fitnessclass.list') }}">
                <div class="product-card">
                    <div class="card-media"
                        style="background-image:url('https://dbfitness.co.nz/wp-content/uploads/2022/06/blog-1.jpg'); height:200px;">
                    </div>
                    <div class="card-title">HIIT Sessions</div>

                </div>
            </a>
        </div>
    </section>
@section('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endsection
@endsection
