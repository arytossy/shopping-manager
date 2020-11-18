@extends('layout')

@section('content')

    <h1>ようこそ！</h1>
    <p class="lead">
        パーティーの買い出しやちょっとしたおつかい<br>
        日々の買い物をみんなで管理しよう！
    </p>
    
    <h2>買い出しマネージャ</h2>
    <p>
        買い物予定のスレッドを立てて、必要なものをリストアップ<br>
        フレンドに情報をリアルタイムで共有できる<br>
        後からほしいものをどんどん追加、誰が頼んだかもすぐわかる！<br>
        「買うの忘れた(T-T)」がもうおこらない！<br>
        さあ、快適なお買い物ライフを始めよう！！
    </p>
    
    <a class="btn btn-primary btn-lg" href="{{ route('register') }}">はじめる！</a><br>
    <a href="{{ route('login') }}">ログイン</a>

@endsection