@extends('layouts.app')

@section('content')

    <div id="welcome" class="row">
        <div class="col">
            <h1>ようこそ！</h1>
            <p class="lead mt-4">
                「あれ買い忘れた！」<br>
                「誰がどれだっけ、、、」<br>
                悩んでいませんか？？？
            </p>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col">
            <h3>買い出しマネージャ</h3>
            <hr>
            <p>
                買い物予定のスレッドを立てて、、、<br>
                ・必要なものをリストアップ！<br>
                ・友だちにリアルタイムで共有！<br>
                ・誰が頼んだかすぐわかる！<br>
                パーティーの買い出しから<br>
                ちょっとしたおつかいまで<br>
                さあ、快適なお買い物ライフを始めよう！！
            </p>
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col text-center">
            <a class="btn btn-primary btn-lg btn-block" href="{{ route('register') }}">はじめる！</a>
            <a href="{{ route('login') }}">ログイン</a>
        </div>
    </div>

@endsection

@section('style')
    #welcome {
        position: relative;
        background-image: url('/images/shopping.jpg');
        background-size: cover;
        height: 300px;
    }
    
    #welcome::after {
        content: '';
        background-color: rgba(0,0,0,0.3);
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    
    #welcome .col {
        z-index: 2;
        position: absolute;
        bottom: 0;
        text-align: right;
        color: white;
    }
@endsection