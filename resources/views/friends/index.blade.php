@extends('layouts.top')

@section('top.content')
    
    @foreach ($friends as $friend)
        <div>
            {!! Form::open(['route' => 'friends.destroy', 'class' => 'd-inline-block']) !!}
                {!! Form::hidden('target_id', $friend->id) !!}
                <button type="submit"><i class="fas fa-minus-circle text-danger"></i></button>
            {!! Form::close() !!}
            <img width="30" height="30" src="{{ $friend->avatar }}">
            <span>{{ $friend->name }}</span>
        </div>
    @endforeach
    
    <button ><i class="fas fa-plus-circle text-success"></i></button>
    
    <div class="card">
        <div class="card-header">
            <button data-toggle="collapse" data-target="#fromReqList">友だちリクエスト</button>
        </div>
        <div class="collapse" id="fromReqList">
            <div class="card-body">
                @foreach ($requests__from as $req)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <img width="30" height="30" src="{{ $req->avatar }}">
                            <span>{{ $req->name }}</span>
                        </div>
                        {!! Form::open(['route' => 'friends.accept']) !!}
                            {!! Form::hidden('target', $req->id) !!}
                            {!! Form::submit('承認', ['class' => 'btn btn-primary btn-sm']) !!}
                        {!! Form::close() !!}
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
    
    <div class="card">
        <div class="card-header">
            <button data-toggle="collapse" data-target="#toReqList">承認待ち</button>
        </div>
        <div class="collapse" id="toReqList">
            <div class="card-body">
                @foreach ($requests__to as $req)
                    <div class="d-flex justify-content-between mb-2">
                        <div>
                            <img width="30" height="30" src="{{ $req->avatar }}">
                            <span>{{ $req->name }}</span>
                        </div>
                        {!! Form::open(['route' => 'friends.destroy']) !!}
                            {!! Form::hidden('target', $req->id) !!}
                            {!! Form::submit('取消', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
    
@endsection