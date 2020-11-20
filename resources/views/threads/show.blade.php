@extends('layouts.app')

@section('content')

    <section id="threadDetail">
        <div id="threadDetailHeader" class="row">
            <div class="col d-flex justify-content-between">
                <a data-toggle="collapse" href="#detailContent">
                    {{ $thread->title }}
                </a>
                <a data-toggle="modal" href="#threadEditDialog">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        <div class="collapse" id="detailContent">
            <div class="row border-bottom py-1">
                <div class="col-4 font-weight-bold">場所</div>
                <div class="col-8">{{ $thread->where_go }}</div>
            </div>
            <div class="row border-bottom py-1">
                <div class="col-4 font-weight-bold">日時</div>
                <div class="col-8">{{ date_create($thread->when_go)->format('Y/m/d') }}</div>
            </div>
            <div class="row border-bottom py-1">
                <div class="col-4 font-weight-bold">メンバー</div>
                <div class="col-8">
                    @foreach ($members as $member)
                        <div>
                            {!! Form::open(['route' => 'members.destroy', 'class' => 'd-inline-block']) !!}
                                {!! Form::hidden('target_id', $member->id) !!}
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            {!! Form::close() !!}
                            <img width="30" height="30" src="{{ $member->avatar }}">
                            <span>{{ $member->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    
    <section id="itemList">
        <div id="itemListHeader" class="row">
            <div class="col-1"><a href=""><i class="fas fa-plus-circle text-success"></i></a></div>
            <div class="col-7">買うもの</div>
            <div class="col-2">必要</div>
            <div class="col-2">購入</div>
        </div>
        @foreach ($items as $item)
            <div class="row border-bottom py-1">
                <div class="col-1"><input type="checkbox"></div>
                <div class="col-7">
                    <a data-toggle="collapse" href="#orders{{ $item->id }}">
                        {{ $item->name }}
                    </a>
                </div>
                <div class="col-2">{{ $item->get_total() }}</div>
                <div class="col-2"><a href="">{{ $item->bought_number }}</a></div>
            </div>
            <div class="collapse overflow-auto" id="orders{{ $item->id }}">
                @if ($item->is_shared)
                    <div class="row py-1">
                        <div class="col-1">
                            {!! Form::open(['route' => ['items.destroy', 'item' => $item->id], 'method' => 'delete']) !!}
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-7">みんなでシェア</div>
                        <div class="col-2"><a href="">{{ $item->get_total() }}</a></div>
                        <div class="col-2"></div>
                    </div>
                @else
                    @foreach ($item->users as $orderer)
                        <div class="row">
                            <div class="col-1">
                                {!! Form::open(['route' => 'orders.destroy']) !!}
                                    {!! Form::hidden('target_id', $orderer->id) !!}
                                    <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-7">
                                <img width="30" height="30" src="{{ $orderer->avatar }}">
                                <span>{{ $orderer->name }}</span>
                            </div>
                            <div class="col-2">
                                @if (Auth::id() == $orderer->id)
                                    <a href="">{{ $orderer->pivot->required_number }}</a>
                                @else
                                    {{ $orderer->pivot->required_number }}
                                @endif
                            </div>
                            <div class="col-2"></div>
                        </div>
                    @endforeach
                    <div class="row py-1">
                        <div class="offset-1 col-7">
                            <a href=""><i class="fas fa-plus-circle text-success"></i> 自分も欲しい！</a>
                        </div>
                    </div>
                @endif
                <div class="row border-bottom"></div>
            </div>
        @endforeach
    </section>
    
    <section id="chatArea">
        <div id="chatScrollInner">
            @foreach ($messages as $message)
                <div class="row my-2">
                    @if (Auth::id() == $message->user->id)
                        <div class="col">
                            <span class="mybubble">{{ $message->content }}</span>
                        </div>
                    @else
                        <div class="col d-flex">
                            <img width="30" height="30" src="{{ $message->user->avatar }}">
                            <div class="ml-2">
                                <span class="said_by">{{ $message->user->name }}</span>
                                <span class="bubble">{{ $message->content }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    
    <div id="messageSender">
        {!! Form::open(['route' => 'messages.store', 'class' => 'd-flex']) !!}
            {!! Form::textarea('content', null, ['rows' => 1]) !!}
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i></button>
        {!! Form::close() !!}
    </div>
    
    <!--以下モーダルダイアログ-->
    
    @include('modals.thread_edit')

@endsection

@section('style')

    #threadDetailHeader {
        background-color: #eee;
        padding: 5px 0;
        font-weight: bold;
    }
    
    #itemListHeader {
        font-weight: bold;
        border-bottom: 5px double #ccc;
        padding: 5px 0;
    }
    
    #chatArea {
        height: 50vh;
        overflow: hidden scroll;
    }
    
    .said_by {
        font-size: 10px;
        color: #888;
        display: block;
    }
    
    .bubble {
        display: block;
        background-color: #eee;
        border-radius: 5px;
        padding: 0 5px;
    }
    
    .bubble::before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-right: 7px solid #eee;
        border-top: 2px solid transparent;
        border-bottom: 3px solid transparent;
        transform: translate(-12px, 5px)
    }
    
    .mybubble {
        display: inline-block;
        float: right;
        background-color: #6e6;
        border-radius: 5px;
        padding: 0 5px;
    }
    
    .mybubble::after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-left: 7px solid #6e6;
        border-top: 2px solid transparent;
        border-bottom: 3px solid transparent;
        transform: translate(5px, 5px)
    }
    
    #messageSender{
        position: sticky;
        bottom: 0;
    }
    
    .btn-wrapper {
        border: none;
        background-color: transparent;
    }
    
@endsection

@section('script')
    document.getElementById('chatScrollInner').scrollIntoView(false);
@endsection