@extends('layouts.app')

@section('content')
    
    <div class="my-4 ml-5">
        @include('parts.profile')
    </div>
    
    
    <ul class="nav nav-tabs nav-fill">
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('friends.index') ? 'active' : '' }}" href="{{ route('friends.index') }}">友だち</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('threads.index') ? 'active' : '' }}" href="{{ route('threads.index') }}">スレッド一覧</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('threads.create') ? 'active' : '' }}" href="{{ route('threads.create') }}">スレッド作成</a>
        </li>
    </ul>
    
    <div class="mt-3">
        @yield('top.content')
    </div>

@endsection