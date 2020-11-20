@extends('layouts.app')

@section('content')
    
    {{-- スレッド詳細情報 --}}
    <section id="threadDetail">
        
        <div id="threadDetailHeader" class="row">
            <div class="col-10">
                <a data-toggle="collapse" href="#detailContent">
                    {{ $thread->title }}
                </a>
            </div>
            <div class="col-2">
                {{-- スレッド詳細編集アイコン --}}
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
                <div class="col-6">
                    @foreach ($members as $member)
                        <div>
                            {{-- 除名アイコン --}}
                            {!! Form::open(['route' => 'members.destroy', 'class' => 'd-inline-block']) !!}
                                {!! Form::hidden('thread_id', $thread->id) !!}
                                {!! Form::hidden('user_id', $member->id) !!}
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            {!! Form::close() !!}
                            <img width="30" height="30" src="{{ $member->avatar }}">
                            <span>{{ $member->name }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="col-2">
                    <a data-toggle="modal" href="#memberAddDialog">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        
    </section>
    
    
    {{-- 買うものリスト --}}
    <section id="itemList">
        
        {{-- ヘッダ --}}
        <div id="itemListHeader" class="row">
            <div class="col-1">
                {{-- 買うもの追加アイコン --}}
                <a data-toggle="modal" href="#itemCreateDialog">
                    <i class="fas fa-plus-circle text-success"></i>
                </a>
            </div>
            <div class="col-7">買うもの</div>
            <div class="col-2">必要</div>
            <div class="col-2">購入</div>
        </div>
        
        {{-- リスト --}}
        @foreach ($items as $item)
            <div class="row border-bottom py-1">
                <div class="col-1"><input type="checkbox"></div>
                <div class="col-7">
                    {{-- 品目名をタップすると頼んだ人一覧が表示される --}}
                    <a data-toggle="collapse" href="#orders{{ $item->id }}">
                        {{ $item->name }}
                    </a>
                </div>
                <div class="col-2">{{ $item->get_total() }}</div>
                <div class="col-2">
                    {{-- 購入数の数字をタップすると購入数変更ダイアログが表示される --}}
                    {{-- @attr data-url => フォームのactionを分岐させるためにURLを生成 --}}
                    <a data-toggle="modal" data-url="{{ route('items.update', ['item' => $item->id]) }}" href="#itemUpdateDialog">
                        {{ $item->bought_number }}
                    </a>
                </div>
            </div>
            
            {{-- 頼んだ人一覧 --}}
            <div class="collapse" id="orders{{ $item->id }}">
                
                {{-- 「みんなでシェア」の場合は誰でも削除、必要数変更できる --}}
                @if ($item->is_shared)
                    <div class="row py-1">
                        <div class="col-1">
                            {{-- 買うもの削除アイコン --}}
                            {!! Form::open(['route' => ['items.destroy', 'item' => $item->id], 'method' => 'delete']) !!}
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-7">みんなでシェア</div>
                        <div class="col-2">
                            {{-- 必要数をタップすると必要数変更ダイアログが表示される --}}
                            <a data-toggle="modal" data-item="{{ $item->id }}" href="#orderChangeDialog">
                                {{ $item->get_total() }}
                            </a>
                        </div>
                        {{-- 空白（購入数列） --}}
                        <div class="col-2"></div>
                    </div>
                    
                {{-- 個人的なオーダー --}}
                @else
                    {{-- 自分が既にオーダーしているかどうかのフラグ --}}
                    <?php $have_ordered = false ?>
                    
                    @foreach ($item->users as $orderer)
                        <div class="row">
                            <div class="col-1">
                                {{-- 自分が頼んだ場合はオーダーを取り消せる --}}
                                @if (Auth::id() == $orderer->id)
                                    {!! Form::open(['route' => 'orders.destroy']) !!}
                                        {!! Form::hidden('item_id', $item->id) !!}
                                        <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                    {!! Form::close() !!}
                                @endif
                            </div>
                            <div class="col-7">
                                <img width="30" height="30" src="{{ $orderer->avatar }}">
                                <span>{{ $orderer->name }}</span>
                            </div>
                            <div class="col-2">
                                {{-- 自分が頼んだ場合は必要数を変更できる --}}
                                @if (Auth::id() == $orderer->id)
                                    {{-- @attr data-item => フォームで対象品目IDをセットするため --}}
                                    <a data-toggle="modal" data-item="{{ $item->id }}" href="#orderChangeDialog">
                                        {{ $orderer->pivot->required_number }}
                                    </a>
                                    <?php $have_ordered = true ?>
                                @else
                                    {{ $orderer->pivot->required_number }}
                                @endif
                            </div>
                            <div class="col-2"></div>
                        </div>
                    @endforeach
                    {{-- まだ自分が頼んでいなければ、便乗アイコンを表示 --}}
                    @if (! $have_ordered)
                        <div class="row py-1">
                            <div class="offset-1 col-7">
                                {{-- @attr data-item => フォームで対象品目IDをセットするため --}}
                                <a data-toggle="modal" data-item="{{ $item->id }}" href="#orderAddDialog">
                                    <i class="fas fa-plus-circle text-success"></i> 自分も欲しい！
                                </a>
                            </div>
                        </div>
                    @endif
                    
                @endif
                
                {{-- 境界線 --}}
                <div class="row border-bottom"></div>
                
            </div>
        @endforeach
    </section>
    
    
    {{-- チャットエリア（メッセージが多い場合はスクロール表示） --}}
    <section id="chatArea">
        {{-- このページ表示時のデフォルトスクロール位置を一番下にするためのラッパ --}}
        <div id="chatScrollInner">
            @foreach ($messages as $message)
                <div class="row my-2">
                    @if (Auth::id() == $message->user->id)
                        <div class="col d-flex justify-content-end mr-3">
                            {!! Form::open(['route' => ['messages.destroy', $message->id], 'method' => 'delete']) !!}
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            {!! Form::close() !!}
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
    
    
    {{-- チャットメッセージ投稿用フォーム（画面下にstickyで常設） --}}
    <div id="messageSender">
        {!! Form::open(['route' => 'messages.store', 'class' => 'd-flex']) !!}
            {!! Form::textarea('content', null, ['rows' => 1]) !!}
            {!! Form::hidden('thread_id', $thread->id) !!}
            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i></button>
        {!! Form::close() !!}
    </div>
    
    
    {{-- 以下モーダルダイアログ--}}
    @include('modals.thread_edit')
    @include('modals.item_create')
    @include('modals.item_update')
    @include('modals.order_add')
    @include('modals.order_change')
    @include('modals.member_add')

@endsection


{{-- このページ固有スタイル --}}
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
        white-space: pre-wrap;
    }
    
    .bubble::before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-right: 7px solid #eee;
        border-top: 2px solid transparent;
        border-bottom: 3px solid transparent;
        transform: translate(-12px, 5px);
    }
    
    .mybubble {
        display: inline-block;
        background-color: #6e6;
        border-radius: 5px;
        padding: 0 5px;
        white-space: pre-wrap;
    }
    
    .mybubble::after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-left: 7px solid #6e6;
        border-top: 3px solid transparent;
        border-bottom: 2px solid transparent;
        transform: translate(4px, 15px);
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


{{-- このページ固有js --}}
@section('script')

    // チャット内容のスクロールを一番下に
    $('#chatScrollInner').get(0).scrollIntoView(false);
    
    // トグラによってモーダルダイアログの内容を分岐させる
    //　詳しくはBootstrapのドキュメントのComponents->Modal->Varying modal contentを参照
    $('#itemUpdateDialog').on('show.bs.modal', function (event) {
        var toggler = $(event.relatedTarget);
        var url = toggler.data('url');
        var boughtNumber = parseInt(toggler.text());
        
        var modal = $(this);
        modal.find('form').attr('action', url);
        modal.find('input[name="bought_number"]').val(boughtNumber);
    });
    
    $('#orderAddDialog').on('show.bs.modal', function (event) {
        var toggler = $(event.relatedTarget);
        var itemId = toggler.data('item');
        
        var modal = $(this);
        modal.find('input[name="item_id"]').val(itemId);
    });
    
    $('#orderChangeDialog').on('show.bs.modal', function (event) {
        var toggler = $(event.relatedTarget);
        var itemId = toggler.data('item');
        var requiredNumber = parseInt(toggler.text());
        
        var modal = $(this);
        modal.find('input[name="item_id"]').val(itemId);
        modal.find('input[name="required_number"]').val(requiredNumber);
    });
@endsection