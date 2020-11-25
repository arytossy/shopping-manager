<div class="d-flex">
    <img class="d-block" width="64" height="64" src="{{ Auth::user()->avatar }}">
    <div class="pl-3" style="min-width: 0;">
        <h5>{{ Auth::user()->name }}</h5>
        <p class="text-muted">{{ Auth::user()->email }}</p>
    </div>
</div>
<a class="btn btn-warning text-white" href="{{ route('profile.edit') }}">プロフィールを編集</a>