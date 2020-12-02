<header>
    <nav class="navbar navbar-dark bg-primary">
        <a class="navbar-brand" href="/"><i class="fas fa-shopping-cart"></i> 買い出しマネージャ</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('threads.index') }}">スレッド一覧</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('threads.create') }}">新しいスレッドを作成</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('friends.index') }}">友だち一覧</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img width="30" height="30" src="{{ Auth::user()->avatar }}">
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('friends.index') }}">プロフィール</a>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">プロフィールを編集</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}">ログアウト</a>
                        </div>
                    </li>
                @else
                     <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">新規登録</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>