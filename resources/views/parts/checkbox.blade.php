@if ($item->bought_number >= $item->get_total())
    {!! Form::open(['route' => ['items.update', $item->id], 'method' => 'put']) !!}
        {!! Form::hidden('bought_number', 0) !!}
        <button type="submit" class="btn-wrapper"><i class="fas fa-check-square text-primary"></i></button>
    {!! Form::close() !!}
@elseif ($item->bought_number > 0)
    {!! Form::open(['route' => ['items.update', $item->id], 'method' => 'put']) !!}
        {!! Form::hidden('bought_number', $item->get_total()) !!}
        <button type="submit" class="btn-wrapper"><i class="fas fa-check-square text-warning"></i></button>
    {!! Form::close() !!}
@elseif ($item->bought_number == 0)
    {!! Form::open(['route' => ['items.update', $item->id], 'method' => 'put']) !!}
        {!! Form::hidden('bought_number', $item->get_total()) !!}
        <button type="submit" class="btn-wrapper"><i class="far fa-square text-secondary"></i></button>
    {!! Form::close() !!}
@endif