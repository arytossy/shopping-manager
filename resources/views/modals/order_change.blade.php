@component('components.modal')

    @slot('modal_name') orderChange @endslot
    
    @slot('modal_title') 必要数変更 @endslot
    
    @slot('go_text') 更新 @endslot
    
    {!! Form::open(['route' => 'orders.change', 'id' => 'orderChangeForm']) !!}
        <div class="form-group">
            {!! Form::label('required_number', '必要数') !!}
            {!! Form::number('required_number', 0, ['class' => 'form-control', 'required' => true, 'min' => 1, 'max' => 10000]) !!}
        </div>
        {!! Form::hidden('item_id') !!}
    {!! Form::close() !!}

@endcomponent