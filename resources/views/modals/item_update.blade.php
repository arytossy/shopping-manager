@component('components.modal')

    @slot('modal_name') itemUpdate @endslot
    
    @slot('modal_title') 購入数変更 @endslot
    
    @slot('go_text') 更新 @endslot
    
    {!! Form::open(['method' => 'put', 'id' => 'itemUpdateForm']) !!}
        <div class="form-group">
            {!! Form::label('bought_number', '購入数') !!}
            {!! Form::number('bought_number', 0, ['class' => 'form-control', 'required' => true, 'min' => 0]) !!}
        </div>
    {!! Form::close() !!}

@endcomponent