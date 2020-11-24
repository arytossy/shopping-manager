@extends('layouts.app')

@section('content')

    <h2 class="my-4">ユーザー登録</h2>
    
    {!! Form::open(['route' => 'register.post', 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('name', 'ユーザー名') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'メールアドレス') !!}
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'パスワード') !!}
            {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password_confirmation', 'パスワード確認用') !!}
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'required' => true]) !!}
        </div>
        {{-- アバター登録（未実装）
        <div class="form-group">
            {!! Form::label('avatar', 'アバター') !!}
            {!! Form::file('avatar', ['class' => 'form-control']) !!}
        </div>
        --}}
        {!! Form::submit('登録', ['class' => 'btn btn-primary btn-block mt-4']) !!}
    {!! Form::close() !!}

@endsection