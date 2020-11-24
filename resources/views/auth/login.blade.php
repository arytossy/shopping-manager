@extends('layouts.app')

@section('content')

    <h2>ログイン</h2>
    
    {!! Form::open(['route' => 'login.post']) !!}
        <div class="form-group">
            {!! Form::label('email', 'メールアドレス') !!}
            {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', 'パスワード') !!}
            {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
        </div>
        {!! Form::submit('ログイン', ['class' => 'btn btn-primary btn-block']) !!}
    {!! Form::close() !!}

@endsection