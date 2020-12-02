<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>買い出しマネージャ</title>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body>
        <div id="wrapper">
            <section id="upperSection">
                @include('parts.header')
                <main class="container">
                    @yield('content')
                </main>
                @yield('message_sender')
            </section>
            <section id="lowerSection">
                @include('parts.footer')
            </section>
            @include('parts.error_alert')
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
