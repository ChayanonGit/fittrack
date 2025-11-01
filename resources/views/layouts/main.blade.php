<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
    <title> </title>
</head>



<body>
    <header id="app-cmp-main-header">

        <nav class="app-cmp-user-panel">

            <ul class="app-cmp-links">
                <li>
                    <a href="{{ route('home') }}">Fittrack</a>
                </li>
                {{-- user menu --}}

                <li>
                    <a href="{{ route('shop.view-shop') }}">shop</a>
                </li>

                <li>
                    <a href="{{ route('shop.view-class') }}">fitness Class</a>
                </li>

                <li>
                    <a href="">My Order</a>
                </li>

                {{-- Admin Menu --}}
                <li>
                    <a href="">Order</a>
                </li>

                <li>
                    <a href="{{ route('fitnessclass.list') }}">fitness Class</a>
                </li>
                <li><a href="{{ route('products.list') }}">Product</a>
                </li>

                <li>
                    <a href="{{ route('category.list') }}">Category</a>
                </li>
            </ul>

        </nav>



        <form action="{{ route('logout') }}" method="post">

            @csrf

            <a href="{{ route('users.view-selves') }}" class="app-cl-code">{{ \Auth::user()->name }}</a>

            <button type="submit">Logout</button>

        </form>

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
    @yield('scripts')
</body>


</html>
