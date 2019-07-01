<!doctype html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous" />
        <link rel="stylesheet" href="{{asset('css/uello.css')}}" />

        <title>Uello :: Teste</title>
    </head>
    <body>
        <div class="loading">
            <div class="spinner"></div>
        </div>
        <div class="container-fluid">
            @yield('content')
        </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_GEOENCODING_KEY')}}" async defer></script>
    <script src="{{asset('js/uello.js')}}"></script>
    </body>
</html>