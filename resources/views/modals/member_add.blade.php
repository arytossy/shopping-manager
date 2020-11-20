@component('components.modal')

    @slot('modal_name') memberAdd @endslot
    
    @slot('modal_title') メンバー追加 @endslot
    
    @slot('go_text') 追加 @endslot
    
    @if ($not_member_friends->count() > 0)
        {!! Form::open(['route' => 'members.add', 'id' => 'memberAddForm']) !!}
            <div class="form-group">
                @foreach ($not_member_friends as $friend)
                    <div class="form-check">
                        <label class="form-check-label">
                            {!! Form::checkbox('members[]', $friend->id, false, ['class' => 'form-check-input']) !!}
                            <img width="30" height="30" src="{{ $friend->avatar }}">
                            {{ $friend->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            {!! Form::hidden('thread_id', $thread->id) !!}
        {!! Form::close() !!}
    @else
        <div class="alert alert-warning" role="alert">
            追加できる友だちがもういません！<br>
            <a href="{{ route('friends.index') }}">友だちを追加する？</a>
        </div>
    @endif
    
    

@endcomponent