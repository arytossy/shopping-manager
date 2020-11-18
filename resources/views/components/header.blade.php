<header>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
        <a class="navbar-brand" href="/">買い出しマネージャ</a>
        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="">スレッド一覧</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">新しいスレッドを作成</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">フレンド一覧</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="">プロフィール</a>
                            <a class="dropdown-item" href="">プロフィールを編集</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="">ログアウト</a>
                        </div>
                    </li>
                @else
                     <li class="nav-item">
                        <a class="nav-link" href="">ログイン</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">新規登録</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>