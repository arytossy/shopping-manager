@component('components.modal')

    @slot('modal_name') friendAdd @endslot
    
    @slot('modal_title') 友だち追加 @endslot
    
    @slot('go_text') 友だちリクエスト送信 @endslot
    
    @if ($not_friend_users->count() > 0)
        {!! Form::open(['route' => 'friends.add', 'id' => 'friendAddForm']) !!}
            <div class="form-group">
                @foreach ($not_friend_users as $user)
                    <div class="form-check">
                        <label class="form-check-label">
                            {!! Form::checkbox('friends[]', $user->id, false, ['class' => 'form-check-input']) !!}
                            <img width="30" height="30" src="{{ $user->avatar }}">
                            {{ $user->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        {!! Form::close() !!}
    @else
        <div class="alert alert-warning" role="alert">
            追加できるユーザーがいません！<br>
            ぜひこのサイトをいろんな方に紹介してください！
        </div>
    @endif
    
    

@endcomponent