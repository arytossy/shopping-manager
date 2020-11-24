@extends('layouts.top')

@section('top.content')

    <div class="row">
        <div class="col-10">
            @foreach ($friends as $friend)
                <div>
                    {!! Form::open(['route' => 'friends.destroy', 'class' => 'd-inline-block']) !!}
                        {!! Form::hidden('user_id', $friend->id) !!}
                        <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                    {!! Form::close() !!}
                    <img width="30" height="30" src="{{ $friend->avatar }}">
                    <span>{{ $friend->name }}</span>
                </div>
            @endforeach
        </div>
        <div class="col-1">
            <a data-toggle="modal" href="#friendAddDialog">
                <i class="fas fa-user-plus text-success"></i>
            </a>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <a data-toggle="collapse" href="#fromReqList">友だちリクエスト</a>
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
                                    {!! Form::hidden('user_id', $req->id) !!}
                                    {!! Form::submit('承認', ['class' => 'btn btn-primary btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <a data-toggle="collapse" href="#toReqList">承認待ち</a>
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
                                    {!! Form::hidden('user_id', $req->id) !!}
                                    {!! Form::submit('取消', ['class' => 'btn btn-danger btn-sm']) !!}
                                {!! Form::close() !!}
                            </div>
                        @endforeach
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    {{-- モーダルダイアログ --}}
    @include('modals.friend_add')
    
@endsection