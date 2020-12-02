@extends('layouts.app')

@section('content')
    
    <div class="mx-3 my-3">
        @include('parts.profile')
        <a class="btn btn-warning text-white" href="{{ route('profile.edit') }}">プロフィールを編集</a>
    </div>

    <ul class="nav nav-tabs nav-fill">
        <li class="nav-item">
            <a class="nav-link px-1 {{ Request::routeIs('friends.index') ? 'active' : '' }}" href="{{ route('friends.index') }}">友だち</a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-1 {{ Request::routeIs('threads.index') ? 'active' : '' }}" href="{{ route('threads.index') }}">スレッド一覧</a>
        </li>
        <li class="nav-item">
            <a class="nav-link px-1 {{ Request::routeIs('threads.create') ? 'active' : '' }}" href="{{ route('threads.create') }}">スレッド作成</a>
        </li>
    </ul>
    
    <div class="mt-3">
        @yield('top.content')
    </div>

@endsection