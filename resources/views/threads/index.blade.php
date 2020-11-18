@extends('layouts.top')

@section('top.content')
    
    @foreach ($threads as $thread)
        <a class="h5" href="{{ route('threads.show', ['thread' => $thread->id]) }}">{{ $thread->title }}</a>
        <div class="d-flex justify-content-between text-muted">
            <span>
                @if ($thread->where_go)
                    ＠{{ $thread->where_go }}
                @endif
            </span>
            <span>
                @if ($thread->when_go)
                    {{ date_create($thread->when_go)->format('Y/m/d H:i') }}
                @endif
            </span>
            
        </div>
    @endforeach
    
@endsection