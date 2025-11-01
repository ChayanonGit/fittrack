<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <li>
                    <a href="">Order</a>
                </li>
                <li>
                    <a href="{{ route('fitnessclass.list') }}">fitness Class</a>
                </li>
                </li>

            
                <li><a href="{{ route('products.list') }}">Product</a>
                <li><a href="{{ route('category.list') }}">Category</a>

                </li>
            </ul>

        </nav>

      

        <form action="" method="post">

            @csrf

            <a href=""
                class="app-cl-code"></a>

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
</body>

</html>