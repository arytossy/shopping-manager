<div class="media">
    <img class="bd-placeholder-img" width="64" height="64" src="">
    <div class="media-body">
        <h5>{{ Auth::user()->name }}</h5>
        <p class="text-muted">{{ Auth::user()->email }}</p>
    </div>
</div>
<a class="btn btn-warning text-white" href="{{ route('profile.edit') }}">プロフィールを編集する</a>