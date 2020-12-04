<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>買い出しマネージャ</title>
        <link rel="stylesheet" href="{{ config('app.env') == 'local' ? '/assets/dev/app.css' : mix('assets/app.css') }}">
    </head>
    <body>
        <div id="app">
            
            <div id="wrapper">
                <section id="upperSection">
                    @include('parts.header')
                    <main class="container">
                        @yield('content')
                    </main>
                    @yield('message_sender')
                </section>
                <section id="lowerSection" class="mt-3">
                    @include('parts.footer')
                </section>
                @include('parts.error_alert')
            </div>
            <div id="waitingWrapper">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

        </div>
        <script src="{{ config('app.env') == 'local' ? '/assets/dev/app.js' : mix('assets/app.js') }}"></script>
    </body>
</html>
