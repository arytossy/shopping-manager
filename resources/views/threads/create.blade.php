@extends('layouts.top')

@section('top.content')
    
    {!! Form::open(['route' => 'threads.store']) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル') !!}
            {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('where_go', '場所') !!}
            {!! Form::text('where_go', old('where_go'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('when_go', '日時') !!}
            {!! Form::text('when_go', old('when_go'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <h5>メンバー</h5>
            @foreach ($friends as $friend)
                <div class="form-check">
                    <label class="form-check-label">
                        {!! Form::checkbox('members[]', $friend->id, false, ['class' => 'form-check-input']) !!}
                        <img width="30" height="30" src="{{ $friend->avatar }}">
                        {{ $friend->name }}
                    </label>
                </div>
            @endforeach
        </div>
        {!! Form::submit('作成', ['class' => 'btn btn-success btn-block']) !!}
    {!! Form::close() !!}
    
@endsection