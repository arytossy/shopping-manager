@extends('layouts.app')

@section('content')

    <h2>ユーザー登録</h2>
    
    {!! Form::open(['route' => 'register.post', 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('name', 'ユーザー名') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'メールアドレス') !!}
            {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'パスワード') !!}
            {!! Form::password('password', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', 'パスワード確認用') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('avatar', 'アバター') !!}
            {!! Form::file('avatar', ['class' => 'form-control']) !!}
        </div>
        {!! Form::submit('登録', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}

@endsection