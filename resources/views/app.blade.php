<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta
            content="initial-scale=1, shrink-to-fit=no, width=device-width"
            name="viewport"
        />

        <link href="/css/style.css" rel="stylesheet" />
        <title>Laravel</title>
        <script src="https://kit.fontawesome.com/6b162f348b.js" crossorigin="anonymous"></script>

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

        <!-- Add Material CSS, replace Bootstrap CSS -->
        <link href="/css/material.min.css" rel="stylesheet" />

        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"
        ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Then Material JavaScript on top of Bootstrap JavaScript -->
        <script src="/js/material.min.js"></script>

        <script type="text/javascript">
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: toast => {
                    toast.addEventListener("mouseenter", Swal.stopTimer);
                    toast.addEventListener("mouseleave", Swal.resumeTimer);
                }
            });


            $(document).on('submit', 'form.ajax', function(e){
                e.preventDefault();
                let submitButton = $(this).find("input[type='submit']");
                submitButton.attr('disabled', true);

                const form = $(this);
                const url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    statusCode: {
                        500: function() {
                                Toast.fire({
                                icon: 'error',
                                title: 'Váratlan hiba történt'
                            });
                        }
                    },
                    success: function(data)
                    {
                        Toast.fire({
                            icon: 'success',
                            title: data.message
                        });

                        $( form ).trigger("ajaxSuccess", data);
                    },
                    error: function(data)
                    {
                        Toast.fire({
                            icon: 'error',
                            title: data.responseJSON.message
                        });
                    },
                    complete: function(){
                        submitButton.removeAttr('disabled');
                    }
                });
            });
        </script>

    </head>
    <body>
        @auth

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-print-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item {{Route::current()->getName()  == 'home' ? "active" : ""}}">
                <a class="nav-link" href="{{route('home')}}">Megrendelések <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#diagrams">Diagramok</a>
                </li>
                <li class="nav-item {{Route::current()->getName()  == 'nyomtatvanyok' ? "active" : ""}}">
                <a class="nav-link" href="{{route('nyomtatvanyok')}}">Nyomtatás</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Nyomtatványok
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item {{Route::current()->getName()  == 'szakacs-osszesito' ? "active" : ""}}" href="/nyomtatvanyok/szakacs-osszesito/2020-05-25">Szakács összesitő</a>
                      <a class="dropdown-item {{Route::current()->getName()  == 'futar-heti' ? "active" : ""}}" href="/nyomtatvanyok/futar-heti">Futár heti</a>
                      <a class="dropdown-item" href="#">Heti statisztika</a>
                      <a class="dropdown-item" href="#">Havi statisztika</a>
                      <a class="dropdown-item" href="#">Egyedi dátumos statisztika</a>
                    </div>
                  </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Futárok
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#Futár1">Futár1</a>
                    <a class="dropdown-item" href="#Futár2">Futár2</a>
                    <a class="dropdown-item" href="#Futár3">Futár3</a>
                  </div>
                </li>
              </ul>
            </div>
            <ul class="navbar-nav nav justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="logout-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white" href="#"><i class="fas fa-user" style="margin-right: 8px"></i>{{Auth::user()->username}}</a>
                    <div class="dropdown-menu" aria-labelledby="logout-dropdown">
                        <a class="dropdown-item" style="padding: 0px">
                            <form action="{{route('logout')}}" id="logout-form" method="post">
                                @csrf
                                <button class="text-button" type="submit">
                                    Kijelentkezés
                                </button>
                            </form>
                        </a>
                    </div>
                </li>
              </ul>
          </nav>

          @endauth

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

        @yield('content')

        <footer style="height: 7%;">
        </footer>
    </body>
</html>