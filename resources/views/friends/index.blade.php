@extends('layouts.top')

@section('top.content')

    <div class="row">
        <div class="col-10">
            @if (count($friends) > 0)
                @foreach ($friends as $friend)
                    <div class="row mt-1">
                        <div class="col-1 pl-4">
                            <form method="post" action="{{ route('friends.destroy') }}" onSubmit="return check('{{ $friend->name }}')">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $friend->id }}">
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            </form>
                        </div>
                        <div class="col-10 d-flex">
                            <img width="30" height="30" src="{{ $friend->avatar }}">
                            <span class="pl-2">{{ $friend->name }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning d-flex justify-content-between">
                    <span>友だちを追加しよう！ </span>
                    <i class="far fa-hand-point-right"></i>
                </div>
            @endif
        </div>
        <div class="col-2 pl-0">
            <a data-toggle="modal" href="#friendAddDialog">
                <i class="fas fa-user-plus text-success"></i>
            </a>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <a data-toggle="collapse" href="#fromReqList">友だちリクエスト</a>
                </div>
                <div class="collapse" id="fromReqList">
                    <div class="card-body">
                        @if (count($requests__from) > 0)
                            @foreach ($requests__from as $req)
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex">
                                        <img width="30" height="30" src="{{ $req->avatar }}">
                                        <span class="pl-2">{{ $req->name }}</span>
                                    </div>
                                    {!! Form::open(['route' => 'friends.accept']) !!}
                                        {!! Form::hidden('user_id', $req->id) !!}
                                        {!! Form::submit('承認', ['class' => 'btn btn-primary btn-sm']) !!}
                                    {!! Form::close() !!}
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">友だちリクエストはありません</div>
                        @endif
                        
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
                        @if (count($requests__to) > 0)
                            @foreach ($requests__to as $req)
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="d-flex">
                                        <img width="30" height="30" src="{{ $req->avatar }}">
                                        <span class="pl-2">{{ $req->name }}</span>
                                    </div>
                                    {!! Form::open(['route' => 'friends.destroy']) !!}
                                        {!! Form::hidden('user_id', $req->id) !!}
                                        {!! Form::submit('取消', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                <a data-toggle="modal" href="#friendAddDialog">
                                    友だち追加する？
                                </a>
                            </div>
                        @endif
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    {{-- モーダルダイアログ --}}
    @include('modals.friend_add')
    
@endsection

@section('script')
    function check(target) {
        return window.confirm(`以下の友だちを削除します！\n${target}\nよろしいですか？`);
    }
@endsection