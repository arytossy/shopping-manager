@extends('layout')

@section('content')
    
    <p>トップページ</p>
    <p>ユーザー：{{ Auth::user()->name }}</p>
    
@endsection