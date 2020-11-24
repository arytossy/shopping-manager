@extends('layouts.top')

@section('top.content')
    
    @foreach ($threads as $thread)
        <div class="mt-2">
            <a class="h4" href="{{ route('threads.show', ['thread' => $thread->id]) }}">{{ $thread->title }}</a>
            <div class="d-flex justify-content-between text-muted">
                <span>
                    @if ($thread->where_go)
                        <i class="fas fa-store"></i> {{ $thread->where_go }}
                    @endif
                </span>
                <span>
                    @if ($thread->when_go)
                        <i class="fas fa-clock"></i> {{ date_create($thread->when_go)->format('Y/m/d') }}
                    @endif
                </span>
            </div>
        </div>
    @endforeach
    
@endsection