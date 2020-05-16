<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous">
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #6699ff;
                color: white;
                font-family: "Roboto", sans-serif;
                font-weight: 250;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 30px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .form {
                border-radius: 7px;
                position: relative;
                z-index: 1;
                background: #FFFFFF;
                max-width: 360px;
                margin: 0 auto 100px;
                padding: 30px;
                text-align: center;
                border: 0;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }
            
            .login-page {
                width: 360px;
                padding: 8% 0 0;
                margin: auto;
            }

            .logininput {
                border-radius: 7px;
                font-family: "Roboto", sans-serif;
                background: #f2f2f2;
                width: 100%;
                border: 0;
                margin: 0 0 16px;
                padding: 15px;
                box-sizing: border-box;
                font-size: 14px;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }

            .loginbutton {
                border-radius: 7px;
                font-family: "Roboto", sans-serif;
                text-transform: uppercase;
                background: #6699ff;
                width: 50%;
                border: 0;
                padding: 15px;
                color: #FFFFFF;
                font-size: 14px;
                font-weight: bold;
                -webkit-transition: all 0.3 ease;
                transition: all 0.3 ease;
                cursor: pointer;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }

            .form button:hover,.form button:active,.form button:focus {
                background: #4d88ff;
            }

            .loginlogo {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 100%;
            }

            .center {
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 100%;
            }

        </style>
    </head>
    <body>
       @section('content')
    </body>
</html>
