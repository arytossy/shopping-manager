@extends('layouts.app')

@section('content')

    {{--
    <section id="threadDetail">
        <div id="threadDetailHeader" class="row">
            <div class="col-10">
                <a data-toggle="collapse" href="#detailContent">
                    {{ $thread->title }}
                </a>
            </div>
            <div class="col-2">
                <a data-toggle="modal" href="#threadEditDialog">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        <div id="detailContent" class="collapse">
            <div class="row border-top py-1">
                <div class="col-3 pr-0"><strong>場所</strong></div>
                <div class="col-9">{{ $thread->where_go }}</div>
            </div>
            <div class="row border-top py-1">
                <div class="col-3 pr-0"><strong>日時</strong></div>
                <div class="col-9">{{ date_create($thread->when_go)->format('Y/m/d') }}</div>
            </div>
            <div class="row border-top py-1">
                <div class="col-3 pr-0"><strong>メンバー</strong></div>
                <div class="col-7">
                    @foreach ($members as $member)
                        <div class="row mt-1">
                            <div class="col-1">
                                <form method="post" action="{{ route('members.destroy') }}"
                                        onSubmit="return delete_check('member', '{{ $member->name }}', '{{ Auth::id() == $member->id }}')">
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
                    <a data-toggle="modal" href="#memberAddDialog">
                        <i class="fas fa-user-plus"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    --}}

    <thread-detail
        id="{{ $thread->id }}"
        title="{{ $thread->title }}"
        where-go="{{ $thread->where_go }}"
        when-go="{{ $thread->when_go }}"
        get-members-url="{{ route('members.index') }}"
        get-friends-url="{{ route('friends.get') }}"
        add-members-url="{{ route('members.add') }}"
        delete-members-url="{{ route('members.destroy') }}"
        friend-index-url="{{ route('friends.index') }}"
    ></thread-detail>
    
    {{-- <section id="itemList">
        @include('parts.item_list')
    </section> --}}

    <item-list
        thread-id="{{ $thread->id }}"
        get-items-url="{{ route('items.index') }}"
        update-item-url="{{ route('items.update', '') }}"
    ></item-list>
    
    <chat-area
        my-id="{{ Auth::id() }}"
        thread-id="{{ $thread->id }}"
        get-url="{{ route('messages.index') }}"
        delete-url="{{ route('messages.destroy', '') }}"
    ></chat-area>

    @include('modals.item_create')
    @include('modals.item_update')
    @include('modals.order_add')
    @include('modals.order_change')
    
    <thread-edit-dialog
        thread-id="{{ $thread->id }}"
        title="{{ $thread->title }}"
        where-go="{{ $thread->where_go }}"
        when-go="{{ date('Y-m-d', strtotime($thread->when_go)) }}"
        update-thread-url="{{ route('threads.update', $thread->id) }}"
    ></thread-edit-dialog>

    {{-- <member-add-dialog
        thread-id="{{ $thread->id }}"
        get-friends-url="{{ route('friends.get') }}"
        friend-index-url="{{ route('friends.index') }}"
        add-members-url="{{ route('members.add') }}"
    ></member-add-dialog> --}}

@endsection

@section('message_sender')
    <message-sender
        send-url="{{route('messages.store')}}"
        thread-id="{{$thread->id}}"
    ></message-sender>
@endsection