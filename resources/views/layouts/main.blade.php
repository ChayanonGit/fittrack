<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/popup.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="flash-success" content="{{ session('success') }}">
    <meta name="flash-error" content="{{ session('error') }}">
    <title> </title>
</head>



<body
    @if (session('success')) onload="Swal.fire('สำเร็จ!', '{{ session('success') }}', 'success')"
    @elseif(session('error'))
        onload="Swal.fire('เกิดข้อผิดพลาด!', '{{ session('error') }}', 'error')" @endif>


    <header class="app-cmp-main-header">

        {{-- top bar: user/logout placed here --}}
        <div class="top-bar">
            <div class="container top-bar-inner">
                <div class="top-left">

                </div>

                <div class="top-right">
                    <a href="{{ route('cart.view-cart') }}" class="app-cl-code">cart</a>

                    @auth
                        <a href="{{ route('users.view-selves') }}" class="app-cl-code">{{ Auth::user()->name }}</a>

                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn-custom">Logouts</button>
                        </form>
                    @endauth

                    @guest
                        <button id="loginBtn" class="btn-custom">Login</button>
                    @endguest


                    </form>
                </div>
            </div>
        </div>

        <nav class="app-cmp-user-panel">
            @if (Auth::check())
                @if (Auth::user()->role === 'ADMIN')
                    {{-- left links --}}
                    <div class="app-cmp-links-right">
                        <a href="{{ route('admin.order.view-order') }}">Order</a>
                        <a href="{{ route('fitnessclass.list') }}">Classes</a>
                        <a href=""></a>
                    </div>

                    {{-- centered brand --}}
                    <div class="app-cmp-home">
                        <a href="{{ route('home') }}" class="home">Fittrack</a>
                    </div>


                    {{-- right links --}}
                    <div class="app-cmp-links-left">

                        <a href="{{ route('products.list') }}">Products</a>
                        <a href="{{ route('category.list') }}">Category</a>
                    </div>
                @else
                    {{-- user menu --}}
                    <div class="app-cmp-links-right">
                        <a href="{{ route('shop.view-shop') }}">Shop</a>
                        <a href="{{ route('shop.view-class') }}">Fitness Class</a>
                        <a href="{{ route('order.view-order') }}"></a>
                    </div>

                    {{-- centered brand --}}
                    <div class="app-cmp-home">
                        <a href="{{ route('home') }}" class="home">Fittrack</a>
                    </div>


                    {{-- right links --}}
                    <div class="app-cmp-links-left">
                        <a href="{{ route('order.view-order') }}">My Order</a>
                        <a href=""></a>
                        <a href=""></a>
                        <a href=""></a>
                    </div>
                @endif
            @else
                <div class="app-cmp-links-right">
                    <a href="{{ route('shop.view-shop') }}">Shop</a>
                </div>

                {{-- centered brand --}}
                <div class="app-cmp-home">
                    <a href="{{ route('home') }}" class="home">Fittrack</a>
                </div>


                {{-- right links --}}
                <div class="app-cmp-links-left">
                    <a href="{{ route('shop.view-class') }}">Fitness Class</a>
                </div>
            @endif







        </nav>
    </header>






    </header>


    <main id="app-cmp-main-content">
        <header>
            <h1></h1>
            <div class="app-cmp-notifications">

            </div>
            <div class="app-cmp-notifications">
                {{-- status message --}}
            </div>
            @yield('header')
        </header>

        @yield('content')
    </main>

    <footer id="app-cmp-main-footer">
        &#xA9; from fittrack
    </footer>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    @yield('scripts')
</body>

<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Login</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</div>


</html>
