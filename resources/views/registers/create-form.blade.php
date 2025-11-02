@extends('users.main')

@section('content')
<form action="" method="post">
    @csrf

    <div class="app-cmp-form-detail">
        <label for="app-inp-code">Email</label>
        <input type="email" id="app-inp-code" name="email" value="{{ old('email') }}" required />

        <label for="app-inp-name">Password</label>
        <input type="password" id="app-inp-name" name="password"  required />

        <label for="app-inp-name">Name</label>
        <input type="text" id="app-inp-name" name="name"value="{{ old('name') }}" required />
    </div>

    <div class="app-cmp-form-actions">
        <button type="submit">Create</button>

        <a href=""><button type="button">Cancel</button>
        </a>

    </div>

</form>
@endsection