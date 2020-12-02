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
                        <form method="post" action="{{ route('items.destroy', $item->id) }}" onSubmit="return delete_check('item', '{{ $item->name }}')">
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
                                <form method="post" action="{{ route('orders.destroy') }}" onSubmit="return delete_check('order', '{{ $item->name }}')">
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