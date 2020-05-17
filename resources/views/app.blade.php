<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta content="initial-scale=1, shrink-to-fit=no, width=device-width" name="viewport">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
            <!-- CSS -->
        <!-- Add Material font (Roboto) and Material icon as needed -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i|Roboto+Mono:300,400,700|Roboto+Slab:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Add Material CSS, replace Bootstrap CSS -->
        <link href="css/material.min.css" rel="stylesheet">
    
        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Then Material JavaScript on top of Bootstrap JavaScript -->
        <script src="js/material.min.js"></script>

        <script type="text/javascript">
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #6699ff;
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
                color: white;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .mwelcome {
                margin:30px 0px 30px;
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
                border: 1px solid white;
                margin: 0 0 16px;
                padding: 15px;
                box-sizing: border-box;
                font-size: 14px;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
                
            }

            .loginbutton {
                border: 1px solid white;
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

            input:focus {
                border: 1px solid #6699ff;
            }

            .topnav ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                height: 48px;
                background-color: #333333;
                font-size: 14px;
                font-weight: bold;
                z-index: 1;
            }

            .topnav ul li {
                float: left;
            }

            .topnav ul li a {
                display: block;
                color: white;
                text-align: center;
                padding: 14px 16px;
                text-decoration: none;
            }

            .topnav ul li a:hover:not(.active) {
                background-color: #111;
            }

            .topnav ul li a.active {
                background-color: #6699ff;
            }

            .topnav ul li a:hover{
                background-color: #111111;
            }

            .topnav ul li.right {
                float: right;
            }

            @media screen and (max-width: 600px) {
                .topnav ul li.right, 
                .topnav ul li {
                    float: none;
                }
            }

            .dropbtn {
                display: inline-block;
                color: white;
                text-align: center;
                text-decoration: none;
            }

            li a:hover, .dropdown:hover .dropbtn {
                background-color: #111;
            }

            li.dropdown {
                display: inline-block;
            }

            .dropdown-content {
                display: none;
                position: absolute;
                background-color: #f9f9f9;
                min-width: 160px;
                box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                z-index: 1;
            }

            .dropdown-content a {
                color: black;
                padding: 12px 16px;
                text-decoration: none;
                display: block;
                text-align: left;
                background-color: #333333;
            }

            .dropdown-content a:hover {
                background-color: #f1f1f1;
            }

            .dropdown:hover .dropdown-content {
                display: block;
            }

        </style>
    </head>
    <body>
        @if (\Session::has('success'))
            <script type="text/javascript">
                const success = <?php echo json_encode(\Session::get('success')) ?>;
                success.forEach((msg) => {
                    Toast.fire({
                        icon: 'success',
                        title: msg
                    });
                });
            </script>
        @elseif(\Session::has('failure'))
            <script type="text/javascript">
                const failure = <?php echo json_encode(\Session::get('failure')) ?>;
                failure.forEach((msg) => {
                    Toast.fire({
                        icon: 'error',
                        title: msg
                    });
                });

            </script>
        @endif
       @section('content')
    </body>
</html>
