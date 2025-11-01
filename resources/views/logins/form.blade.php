<link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
<body style="background-image: url('/storage/img_bg/bg-img.jpg')">
    <div class="log-from">
        
            <div>
                <h1 class="log-text">
                    login
                </h1>
            </div>
            <form action="{{ route('authenticate') }}" method="post">

                @csrf

                <label>

                    <p>E-mail</p>
                    <input type="email" name="email" required />

                </label><br />

                <label>

                    <p>Password</p>
                    <input type="password" name="password" required  />

                </label><br />

                <button type="submit">Login</button>

                <div class="app-cmp-notifications">

                    @error('credentials')

                    <div role="alert">

                        {{ $message }}

                    </div>

                    @enderror

                </div>

            </form>
        
    </div>
</body>