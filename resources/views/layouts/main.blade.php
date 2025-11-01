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
	<header class="app-cmp-main-header">

		{{-- top bar: user/logout placed here --}}
		<div class="top-bar">
			<div class="container top-bar-inner">
				<div class="top-left">
					
				</div>

				<div class="top-right">
					<form action="{{ route('logout') }}" method="post" class="auth-form">
						@csrf
						<a href="{{ route('cart.view-cart') }}" class="app-cl-code">cart</a>
						<form action="{{ route('logout') }}" method="post">

							@csrf

							@auth
							<a href="{{ route('users.view-selves') }}" class="app-cl-code">
								{{ Auth::user()->name }}
							</a>
							<button type="submit" class="app-cl-code">Logout</button>

							@endauth

							@guest
							<a href="{{ route('login') }}" class="app-cl-code">Login</a>
							@endguest



						</form>

					</form>
				</div>
			</div>
		</div>

		<nav class="app-cmp-user-panel">

			{{-- left links --}}
			<div class="app-cmp-links-left">
				<a href="{{ route('shop.view-shop') }}">Shop</a>
				<a href="{{ route('shop.view-class') }}">Fitness Class</a>
				<a href="{{ route('order.view-order') }}">My Order</a>
			</div>

			{{-- centered brand --}}
			<div class="app-cmp-home">
				<a href="{{ route('home') }}" class="home">Fittrack</a>
			</div>


			{{-- right links --}}
			<div class="app-cmp-links-right">
				<a href="#">Order</a>
				<a href="{{ route('fitnessclass.list') }}">Classes</a>
				<a href="{{ route('products.list') }}">Products</a>
				<a href="{{ route('category.list') }}">Category</a>
			</div>

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
		@yield('scripts')
</body>


</html>