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

        <label for="app-inp-name">Role</label>
        <select name="role" id="">
            <option value="" selected>---Please Select---</option>
            <option value="ADMIN" {{ old('role') == 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
            <option value="USER"{{ old('role') == 'USER' ? 'selected' : '' }}>USER</option>
            
        </select>


    </div>

    <div class="app-cmp-form-actions">
        <button type="submit">Create</button>

        <a href=""><button type="button">Cancel</button>
        </a>

    </div>

</form>
@endsection