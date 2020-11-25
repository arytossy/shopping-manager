@extends('layouts.top')

@section('top.content')
    
    @if (count($threads) > 0)
        @foreach ($threads as $thread)
            <div class="mt-2 border-bottom">
                <a class="h4" href="{{ route('threads.show', ['thread' => $thread->id]) }}">
                    {{ $thread->title }}
                </a>
                    <p class="text-muted text-truncate my-0">
                        @if ($thread->where_go)
                            <i class="fas fa-store"></i> {{ $thread->where_go }}
                        @endif
                    </p>
                    <p class="text-muted my-0">
                        @if ($thread->when_go)
                            <i class="fas fa-clock"></i> {{ date_create($thread->when_go)->format('Y/m/d') }}
                        @endif
                    </p>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning d-flex justify-content-between">
            <span>スレッドを作成してみよう！</span>
            <i class="far fa-hand-point-up"></i>
        </div>
    @endif
    
    
@endsection