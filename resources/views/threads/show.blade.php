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
                <div class="col-3 pr-0 font-weight-bold">場所</div>
                <div class="col-9">{{ $thread->where_go }}</div>
            </div>
            <div class="row border-bottom py-1">
                <div class="col-3 pr-0 font-weight-bold">日時</div>
                <div class="col-9">{{ date_create($thread->when_go)->format('Y/m/d') }}</div>
            </div>
            <div class="row border-bottom py-1">
                <div class="col-3 pr-0 font-weight-bold">メンバー</div>
                <div class="col-7">
                    @foreach ($members as $member)
                        <div class="row mt-1">
                            <div class="col-1">
                                <form method="post" action="{{ route('members.destroy') }}"
                                        onSubmit="return check('member', '{{ $member->name }}', '{{ Auth::id() == $member->id }}')">
                                    @csrf
                                    <input type="hidden" name="thread_id" value="{{ $thread->id }}">
                                    <input type="hidden" name="user_id" value="{{ $member->id }}">
                                    <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                </form>
                            </div>
                            <div class="col-10 d-flex">
                                <img width="30" height="30" src="{{ $member->avatar }}">
                                <span class="pl-2">{{ $member->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-2">
                    {{-- メンバー追加アイコン --}}
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
            <div class="col-2 pl-0">必要</div>
            <div class="col-2 pl-0">購入</div>
        </div>
        
        {{-- 買うものリスト --}}
        @if (count($items) == 0)
            <div class="row">
                <div class="col py-3">
                    <div class="alert alert-warning">
                        <i class="far fa-hand-point-up"></i>
                        ＋ボタンを押して買うものを追加しよう！
                    </div>
                </div>
            </div>
        @else
            @foreach ($items as $item)
                <div class="row border-bottom py-2">
                    <div class="col-1">@include('parts.checkbox')</div>
                    <div class="col-7">
                        {{-- 品目名をタップすると頼んだ人一覧が表示される --}}
                        <a data-toggle="collapse" href="#orders{{ $item->id }}">
                            {{ $item->name }}
                        </a>
                    </div>
                    <div class="col-2 pl-0">{{ $item->get_total() }}</div>
                    <div class="col-2 pl-0">
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
                                <form method="post" action="{{ route('items.destroy', $item->id) }}" onSubmit="return check('item', '{{ $item->name }}')">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                </form>
                            </div>
                            <div class="col-7">みんなでシェア</div>
                            <div class="col-2 pl-0">
                                {{-- 必要数をタップすると必要数変更ダイアログが表示される --}}
                                <a data-toggle="modal" data-item="{{ $item->id }}" href="#orderChangeDialog">
                                    {{ $item->get_total() }}
                                </a>
                            </div>
                            {{-- 空白（購入数列） --}}
                            <div class="col-2 pl-0"></div>
                        </div>
                        
                    {{-- 個人的なオーダー --}}
                    @else
                        {{-- 自分が既にオーダーしているかどうかのフラグ --}}
                        <?php $have_ordered = false ?>
                        
                        @foreach ($item->users as $orderer)
                            <div class="row mt-1">
                                <div class="col-1">
                                    {{-- 自分が頼んだ場合はオーダーを取り消せる --}}
                                    @if (Auth::id() == $orderer->id)
                                        <form method="post" action="{{ route('orders.destroy') }}" onSubmit="return check('order', '{{ $item->name }}')">
                                            @csrf
                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                                        </form>
                                    @endif
                                </div>
                                <div class="col-7 d-flex">
                                    <img width="30" height="30" src="{{ $orderer->avatar }}">
                                    <span class="pl-2">{{ $orderer->name }}</span>
                                </div>
                                <div class="col-2 pl-0">
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
                                <div class="col-2 pl-0"></div>
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
        @endif
    </section>
    
    
    {{-- チャットエリア（メッセージが多い場合はスクロール表示） --}}
    <section id="chatArea" class="row py-3">
        {{-- このページ表示時のデフォルトスクロール位置を一番下にするためのラッパ --}}
        <div id="chatScrollInner" class="col">
            @foreach ($messages as $message)
                <div class="row my-2">
                    @if (Auth::id() == $message->user->id)
                        <div class="col d-flex justify-content-end mr-3">
                            <form method="post" action="{{ route('messages.destroy', $message->id) }}" onSubmit="return check('message', '{{ $message->content }}')">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                            </form>
                            <p class="mybubble ml-1">{{ $message->content }}</p>
                        </div>
                    @else
                        <div class="col d-flex">
                            <img width="30" height="30" src="{{ $message->user->avatar }}">
                            <div class="ml-2">
                                <p class="said_by">{{ $message->user->name }}</p>
                                <p class="bubble">{{ $message->content }}</p>
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
            {!! Form::textarea('content', null, ['rows' => 1, 'required' => true]) !!}
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
        padding: 10px 0;
        font-weight: bold;
        font-size: 18px;
    }
    
    #itemListHeader {
        font-weight: bold;
        border-bottom: 5px double #ccc;
        padding: 5px 0;
    }
    
    #chatArea {
        height: 50vh;
        overflow: hidden scroll;
        background-color: #eff;
    }
    
    .said_by {
        font-size: 10px;
        color: #888;
        margin: 0;
    }
    
    .bubble {
        background-color: #eee;
        border-radius: 5px;
        padding: 3px 10px;
        white-space: pre-wrap;
        margin: 0;
    }
    
    .bubble::before {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-right: 7px solid #eee;
        border-top: 2px solid transparent;
        border-bottom: 3px solid transparent;
        transform: translate(-17px, 5px);
    }
    
    .mybubble {
        background-color: #6e6;
        border-radius: 5px;
        padding: 3px 10px;
        max-width: 80%;
        white-space: pre-wrap;
        margin: 0;
    }
    
    .mybubble::after {
        content: '';
        position: absolute;
        width: 0;
        height: 0;
        border-left: 7px solid #6e6;
        border-top: 3px solid transparent;
        border-bottom: 2px solid transparent;
        transform: translate(10px, 15px);
    }
    
    #messageSender{
        position: sticky;
        bottom: 0;
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
    
    // 削除前確認用メソッド
    function check(category, target, isMyself = false) {
        let content = '';
        switch (category) {
            case 'member':
                if (isMyself) {
                    content = 'このスレッドから退出します！\nよろしいですか？';
                } else {
                    content = `以下のユーザーをこのスレッドから外します！\n${target}\nよろしいですか？`;
                }
                break;
            case 'item':
                content = `以下の買うものを削除します！\n${target}\nよろしいですか？`;
                break;
            case 'order':
                content = `以下の品目の自分のオーダーを取り消します。\n${target}\n※最後の一人の場合は品目ごと削除します！\nよろしいですか？`;
                break;
            case 'message':
                content = `以下のコメントを削除します！\n${target}\nよろしいですか？`;
                break;
        }
        
        return window.confirm(content);
    }
@endsection