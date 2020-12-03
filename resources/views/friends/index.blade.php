@extends('layouts.top')

@section('top.content')

    <div class="row">
        <div class="col-10">
            @if (count($friends) > 0)
                @foreach ($friends as $friend)
                    <div class="row mt-1">
                        <div class="col-1 pl-4">
                            <form method="post" action="{{ route('friends.destroy') }}" onSubmit="return delete_check('friend', '{{ $friend->name }}');">
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
            @include('parts.friend_requests')
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            @include('parts.pending_friends')
        </div>
    </div>
    
    {{-- モーダルダイアログ（Vue Component） --}}
    <div id="vueArea">
        <friend-add-dialog
            search_url="{{ route('ajax.users.search') }}"
            add_url="{{ route('friends.add') }}"
            delete_url="{{ route('friends.destroy') }}"
        ></friend-add-dialog>
    </div>
    
@endsection