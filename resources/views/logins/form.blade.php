<div class="">
    <h1>
        login
    </h1>
</div>
<form action="{{ route('authenticate') }}" method="post">

    @csrf

    <label>

        E-mail <input type="email" name="email" required />

    </label><br />

    <label>

        Password <input type="password" name="password" required />

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