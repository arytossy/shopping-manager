@component('components.modal')

    @slot('modal_name') threadEdit @endslot
    
    @slot('modal_title') スレッド情報編集 @endslot
    
    @slot('go_text') 更新 @endslot
    
    {!! Form::model($thread, ['route' => ['threads.update', $thread->id],
                                'method' => 'put',
                                'id' => 'threadEditForm']) !!}
        <div class="form-group">
            {!! Form::label('title', 'タイトル') !!}
            {!! Form::text('title', null, ['class' => 'form-control', 'required' => true]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('where_go', '場所') !!}
            {!! Form::text('where_go', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('when_go', '日にち') !!}
            {!! Form::date('when_go', date_create($thread->when_go), ['class' => 'form-control']) !!}
        </div>
    {!! Form::close() !!}

@endcomponent