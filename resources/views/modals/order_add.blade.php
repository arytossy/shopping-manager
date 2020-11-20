@component('components.modal')

    @slot('modal_name') orderAdd @endslot
    
    @slot('modal_title') オーダー追加 @endslot
    
    @slot('go_text') 追加 @endslot
    
    {!! Form::open(['route' => 'orders.add', 'id' => 'orderAddForm']) !!}
        <div class="form-group">
            {!! Form::label('required_number', '必要数') !!}
            {!! Form::number('required_number', 1, ['class' => 'form-control']) !!}
        </div>
        {!! Form::hidden('item_id') !!}
    {!! Form::close() !!}

@endcomponent