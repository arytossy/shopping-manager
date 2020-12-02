<div id="chatContent" class="row">
    <div id="chatScrollInner" class="col">
        @foreach ($messages as $message)
            <div class="my-2">
                @if (Auth::id() == $message->user->id)
                    <div class="my-message pr-3">
                        <form method="post" action="{{ route('messages.destroy', $message->id) }}" onSubmit="return delete_check('message', '{{ $message->content }}')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn-wrapper"><i class="fas fa-minus-circle text-danger"></i></button>
                        </form>
                        <p class="bubble ml-2">{{ $message->content }}</p>
                    </div>
                @else
                    <div class="message">
                        <img width="30" height="30" src="{{ $message->user->avatar }}">
                        <div class="ml-3">
                            <p class="said_by">{{ $message->user->name }}</p>
                            <p class="bubble">{{ $message->content }}</p>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>