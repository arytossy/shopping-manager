<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>買い出しマネージャ</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
        <style>
            body {
                background-color: #eee;
            }
            * {
                overflow-wrap: break-word;
            }
            #wrapper {
                max-width: 450px;
                min-height: 100vh;
                margin: 0 auto;
                background-color: #fff;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .btn-wrapper {
                border: none;
                background-color: transparent;
                padding: 0;
            }
            @yield('style')
        </style>
    </head>
    <body>
        <div id="wrapper">
            
            <section id="upperSection">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
                
                @include('parts.header')
                
                <main class="container">
                    @yield('content')
                </main>
            </section>
            
            <section id="lowerSection">
                @include('parts.footer')
            </section>
            
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
            <script src="https://kit.fontawesome.com/1707dd4586.js" crossorigin="anonymous"></script>
            <script>@yield('script')</script>
        </div>
    </body>
</html>
