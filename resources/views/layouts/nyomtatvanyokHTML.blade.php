<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <title>Kiskakas Vendéglő</title>

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,600"
            rel="stylesheet"
        />
        <!-- CSS -->
        <!-- Add Material font (Roboto) and Material icon as needed -->
        <link
            href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/icon?family=Material+Icons"
            rel="stylesheet"
        />

        <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <!-- Add Material CSS, replace Bootstrap CSS -->
        <link href="{{asset('css/material.min.css')}}" rel="stylesheet" />
        <script src="{{asset('js/material.min.js')}}"></script>


    </head>
    <body style="background: none !important; font-family: DejaVu Sans, sans-serif !important;">
        @yield('content')
    </body>
</html>