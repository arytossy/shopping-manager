@extends('layouts.top')

@section('top.content')
    
    {!! Form::open(['route' => 'threads.store']) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル') !!}
            {!! Form::text('title', old('title'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('where_go', '場所') !!}
            {!! Form::text('where_go', old('where_go'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('when_go', '日付') !!}
            {!! Form::date('when_go', old('when_go'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            <h5>メンバー</h5>
            @if (count($friends) > 0)
                @foreach ($friends as $friend)
                    <div class="form-check mt-1 ml-3">
                        <label class="form-check-label">
                            {!! Form::checkbox('members[]', $friend->id, false, ['class' => 'form-check-input']) !!}
                            <div class="d-flex">
                                <img width="30" height="30" src="{{ $friend->avatar }}">
                                <span class="pl-2">{{ $friend->name }}</span>
                            </div>
                        </label>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning">
                    <a href="{{ route('friends.index') }}">
                        友だちを追加しよう！
                    </a>
                </div>
            @endif
            
        </div>
        {!! Form::submit('作成', ['class' => 'btn btn-success btn-block']) !!}
    {!! Form::close() !!}
    
@endsection