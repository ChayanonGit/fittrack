@extends('users.main')

@section('header')
<search>
    <form action="" method="get" class="app-cmp-search-form">
        <div class="app-cmp-form-detail">
            <label for="app-criteria-term">Search</label>
            <input type="text" id="app-criteria-term" name="term" value="{{$criteria['term'] }}" />
        </div>

        <div class="app-cmp-form-actions">
            <button type="submit" class="primary">Search</button>
            <a href="{{route('users.list')}}">
                <button type="button" class="accent">X</button>
            </a>
        </div>
    </form>
</search>

<div class="app-cmp-links-bar">
    <nav>

        <ul class="app-cmp-links">


            <li>

                <a href="{{route('users.create-form')}}">New User</a>

            </li>


        </ul>

    </nav>
    {{-- {{ $users->withQueryString()->links() }} --}}
</div>
@endsection

@section('content')
<table class="app-cmp-data-list">
    <colgroup>
        <col style="width: 30ch;" />
    </colgroup>

    <thead>
        <tr>
            <th>Email</th>
            <th>Name</th>
            <th>Role</th>
        </tr>
    </thead>

    <tbody>
        {{-- @php
        session()->put('bookmarks.users.view',url()->full());
        session()->put('bookmarks.users.view-selves',url()->full());

        @endphp --}}
        @foreach($users as $user)
        <tr>
            <td><a href="{{ route('users.view', [
                            'user' => $user->email,
                        ]) }}"
                    class="app-cl-code">{{ $user->email }}</a></td>
            <td>{{$user->name}}</td>
            <td>{{$user->role}}</td>
        </tr>
        @endforeach

    </tbody>
</table>
@endsection