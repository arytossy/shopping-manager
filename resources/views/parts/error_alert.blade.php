@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert" style="position: absolute; top: 56px; font-size: 13px;">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif