@component('components.modal')

    @slot('modal_name') itemCreate @endslot
    
    @slot('modal_title') 買うもの追加 @endslot
    
    @slot('go_text') 追加 @endslot
    
    {!! Form::open(['route' => 'items.store', 'id' => 'itemCreateForm']) !!}
        <div class="form-group">
            {!! Form::label('name', '品名') !!}
            {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('required_number', '必要数') !!}
            {!! Form::number('required_number', 1, ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-check">
            {!! Form::checkbox('is_shared', 'yes', false, ['class' => 'form-check-input']) !!}
            {!! Form::label('is_shared', 'みんなでシェア', ['class' => 'form-check-label']) !!}
        </div>
        <div class="alert alert-info">
            「みんなでシェア」にすると、誰でも削除、必要数追加ができる
        </div>
        {!! Form::hidden('thread_id', $thread->id) !!}
    {!! Form::close() !!}

@endcomponent