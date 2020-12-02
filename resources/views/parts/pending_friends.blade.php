<div class="card">
    <div class="card-header">
        <a data-toggle="collapse" href="#toReqList">承認待ち</a>
    </div>
    <div class="collapse" id="toReqList">
        <div class="card-body">
            @if (count($requests__to) > 0)
                @foreach ($requests__to as $req)
                    <div class="d-flex justify-content-between mb-2">
                        <div class="d-flex">
                            <img width="30" height="30" src="{{ $req->avatar }}">
                            <span class="pl-2">{{ $req->name }}</span>
                        </div>
                        {!! Form::open(['route' => 'friends.destroy']) !!}
                            {!! Form::hidden('user_id', $req->id) !!}
                            {!! Form::submit('取消', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning">
                    <a data-toggle="modal" href="#friendAddDialog">
                        友だち追加する？
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>