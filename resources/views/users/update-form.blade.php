@extends('users.main')

@section('content')

<form action="{{ route('users.update', [
        'user' => $users->email,
    ]) }}" method="post">
    @csrf




    <div class="app-cmp-form-detail">


        <label for="app-inp-description">Email</label> <input type="text" id="app-inp-name" name="name" value="{{ old('name', $users->email) }}" required />
        



        <label for="app-inp-name">Name</label> <input type="text" id="app-inp-name" name="name" value="{{ old('name', $users->name) }}" required />
        <label for="app-inp-description">Role</label><input type="text" id="app-inp-name" name="name" value="{{ old('name', $users->role) }}" required />

        @if($users->email === \Auth::user()->email) 
        <input type="hidden" name="role" value="{{ $users->role }}">
        @else @if($users->role=="ADMIN") <select name="role" id="">
            <option value="USER" {{ old('role', $users->role) === 'USER' ? 'selected' : '' }}>USER</option>
            <option value="ADMIN" {{ old('role', $users->role) === 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
        </select>
        @else <select name="role" id="">
            <option value="USER" {{ old('role', $users->role) === 'USER' ? 'selected' : '' }}>USER</option>
            <option value="ADMIN" {{ old('role', $users->role) === 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
        </select>
        @endif @endif

        <label for="app-inp-price">Password</label>
        <input type="password" id="app-inp-price" name="password" value="" />

    </div>

    <div class="app-cmp-form-actions">
        <button type="submit">Update</button>
        <a href="{{route('users.view',['user'=>$users->email]) }}"><button type="button">Cancel</button></a>
    </div>
</form>
@endsection