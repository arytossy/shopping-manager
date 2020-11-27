@extends('layouts.app')

@section('content')

    <h2 class="my-4">プロフィール編集</h2>
    
    {!! Form::model(Auth::user(), ['route' => 'profile.update', 'method' => 'put', 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('name', 'ユーザー名') !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'メールアドレス') !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('avatar', 'アバター') !!}<br>
            <img width="100" height="100" src="{{ Auth::user()->avatar }}">
            <p class="ml-4 my-2"><i class="fas fa-arrow-down"></i></p>
            {!! Form::file('avatar', ['accept' => 'image/*', 'class' => 'form-control-file text-truncate']) !!}
        </div>
        <div class="form-check">
            {!! Form::checkbox('is_default', 'yes', false,  ['class' => 'form-check-input']) !!}
            {!! Form::label('is_default', 'デフォルトアバターにする', ['class' => 'form-check-label']) !!}
        </div>
        {!! Form::submit('更新', ['class' => 'btn btn-success btn-block mt-4']) !!}
    {!! Form::close() !!}

@endsection