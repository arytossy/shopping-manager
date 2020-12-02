<div class="card">
    <div class="card-header">
        <a data-toggle="collapse" href="#fromReqList">友だちリクエスト</a>
    </div>
    <div class="collapse" id="fromReqList">
        <div class="card-body">
            @if (count($requests__from) > 0)
                @foreach ($requests__from as $req)
                    <div class="d-flex justify-content-between mb-2">
                        <div class="d-flex">
                            <img width="30" height="30" src="{{ $req->avatar }}">
                            <span class="pl-2">{{ $req->name }}</span>
                        </div>
                        {!! Form::open(['route' => 'friends.accept']) !!}
                            {!! Form::hidden('user_id', $req->id) !!}
                            {!! Form::submit('承認', ['class' => 'btn btn-primary btn-sm']) !!}
                        {!! Form::close() !!}
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning">友だちリクエストはありません</div>
            @endif
        </div>
    </div>
</div>