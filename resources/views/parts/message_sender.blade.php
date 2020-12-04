<div id="messageSender">
    {!! Form::open(['route' => 'messages.store', 'class' => 'd-flex']) !!}
        {!! Form::textarea('content', null, ['rows' => 1, 'required' => true, 'class' => 'form-control']) !!}
        {!! Form::hidden('thread_id', $thread->id) !!}
        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i></button>
    {!! Form::close() !!}
</div>