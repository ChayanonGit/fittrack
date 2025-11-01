@extends('users.main')

@section('header')
<nav>
    <form action="{{ route('users.delete', [
            'user' => $users->email,
        ]) }}" method="post"
        id="app-form-delete">
        @csrf
    </form>

    <ul class="app-cmp-links">
        <li>
            <a href="{{ session()->get('bookmarks.users.view' ,route('users.list')) }}">&lt; Back </a>
        </li>

        <li>
            <a
                href="{{ route('users.update-form', [
                        'user' => $users->email,
                        ]) }}">Update</a>
        </li>


        @can('delete', $users)

        <li class="app-cl-warn">
            <button type="submit" form="app-form-delete" class="app-cl-link">Delete</button>
        </li>
        @endcan
    </ul>
</nav>
@endsection

@section('content')

<dl class="app-cmp-data-detail">
    <dt>Email</dt>
    <dd>
        <span class="app-cl-code">{{$users->email}}</span>
    </dd>

    <dt>Name</dt>
    <dd>
        {{$users->name}}
    </dd>

    <dt>Role</dt>
    <dd>
        [<a href="" class="app-cl-code">
            {{$users->role}} </a>]

    </dd>

</dl>

<pre></pre>
@endsection