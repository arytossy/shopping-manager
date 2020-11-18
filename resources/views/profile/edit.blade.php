@extends('layouts.app')

@section('content')

    <h2>プロフィール編集</h2>
    
    {!! Form::model(Auth::user(), ['route' => 'profile.update', 'method' => 'put']) !!}
        <div class="form-group">
            {!! Form::label('name', 'ユーザー名') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', 'メールアドレス') !!}
            {!! Form::email('email', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('avatar', 'アバター') !!}
            {!! Form::file('avatar', ['class' => 'form-control']) !!}
        </div>
        {!! Form::submit('更新', ['class' => 'btn btn-success btn-block']) !!}
    {!! Form::close() !!}

@endsection