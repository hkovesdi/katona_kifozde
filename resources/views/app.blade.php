<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8" />
        <meta
            content="initial-scale=1, shrink-to-fit=no, width=device-width"
            name="viewport"
        />
        <meta name="_token" content="{{ csrf_token() }}">

        <link href="{{asset('css/style.css')}}" rel="stylesheet" />
        <title>Kiskakas Vendéglő</title>
        <script src="{{asset('js/fontawesome.js')}}"></script>


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
        <link href="{{asset('css/material.min.css')}}" rel="stylesheet" />

        <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"
        ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <!-- Then Material JavaScript on top of Bootstrap JavaScript -->
        <script src="{{asset('js/material.min.js')}}"></script>

        <script type="text/javascript">
        //Force reload the page if loaded via the back button in the browser
        if(performance.navigation.type == 2){
            location.reload();
        }
            $(function() {
                $.ajaxSetup({
                    headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    }
                });
            });

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

            // Scroll position memorization after post request redirect
            document.getScroll = function() {
                if (window.pageYOffset != undefined) {
                    return [pageXOffset, pageYOffset];
                } else {
                    var sx, sy, d = document,
                        r = d.documentElement,
                        b = d.body;
                    sx = r.scrollLeft || b.scrollLeft || 0;
                    sy = r.scrollTop || b.scrollTop || 0;
                    return [sx, sy];
                }
            }
            document.rememberScroll = function() {
                localStorage.setItem('scrollpos', document.getScroll());
            }
            $(document).ready(function() {
                $('[data-toggle="popover"]').popover()
                let scrollPos = localStorage.getItem('scrollpos');
                if(scrollPos !== null) {
                    scrollPos = scrollPos.split(',');
                    window.scrollTo(...scrollPos);
                    localStorage.removeItem('scrollpos');
                }
            });

        </script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
    </head>
    <body>
        @auth

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-print-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                @if(Auth::user()->munkakor != 'Kiszállító')
                    <li class="nav-item dropdown {{Route::current()->getName()  == 'megrendelesek' ? "active" : ""}}">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Futárok
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            @foreach(\App\User::where('munkakor', 'Kiszállító')->orWhere('munkakor', 'Titkárnő')->get() as $kiszallito)
                                <a class="dropdown-item" href="{{route('megrendelesek', $kiszallito->id)}}">{{$kiszallito->nev}}</a>
                            @endforeach
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Route::current()->getName()  == 'tetelek' ? "active" : ""}}" href="{{route('tetelek')}}">Ártábla</a>
                    </li>
                    <li class="nav-item {{Route::current()->getName()  == 'megrendelok' ? "active" : ""}}">
                        <a class="nav-link" href="{{route('megrendelok')}}">Megrendelők</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Nyomtatványok
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item {{Route::current()->getName()  == 'szakacs-osszesito' ? "active" : ""}}" href="/nyomtatvanyok/szakacs-osszesito/{{\Carbon\Carbon::now()->isWeekend() ? \Carbon\Carbon::now()->addDays(7)->startOfWeek()->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')}}">Szakács összesitő</a>
                            <a class="dropdown-item" href="{{route('nyomtatvanyok.osszesito', ['kezdete' => \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'), 'vege' => \Carbon\Carbon::now()->endOfWeek()->format('Y-m-d')])}}">Heti statisztika</a>
                            <a class="dropdown-item" href="{{route('nyomtatvanyok.osszesito', ['kezdete' => \Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'), 'vege' => \Carbon\Carbon::now()->endOfMonth()->format('Y-m-d')])}}">Havi statisztika</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="modal" data-target="#newUserModal" class="nav-link">Új felhasználó</a>
                    </li>
                    @if(Auth::user()->username == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link" href="/log-viewer">Logs</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link {{Route::current()->getName()  == 'megrendelesek' ? "active" : ""}}" href="{{route('megrendelesek', ['user' => Auth::user()])}}">Futárok</a>
                    </li>
                @endif
              </ul>
            </div>
            <ul class="navbar-nav nav justify-content-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="logout-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white" href="#"><i class="fas fa-user" style="margin-right: 8px"></i>{{Auth::user()->nev.' ('.Auth::user()->username.'), '.Auth::user()->munkakor}}</a>
                    <div class="dropdown-menu" aria-labelledby="logout-dropdown">
                        <a class="dropdown-item" style="padding: 0px">
                            <button class="text-button" type="button" data-toggle="modal" data-target="#pwChangeModal">
                                Jelszó változtatás
                            </button>
                        </a>
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

          <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">Új felhasználó létrehozása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('felhasznaloLetrehozas')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="realname">Teljes név</label>
                            <input name="nev" type="text" class="form-control" id="realname">
                        </div>
                        <div class="form-group">
                            <label for="username">Felhasználó név</label>
                            <input name="username" type="text" class="form-control" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Jelszó</label>
                            <input name="password" type="password" class="form-control" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Jelszó ismétlés</label>
                            <input name="confirm" type="password" class="form-control" id="password-confirm">
                        </div>
                        <div class="form-group">
                            <label for="munkakor">Munkakör</label>
                            <select name="munkakor" class="form-control" id="munkakor">
                                @foreach (\App\Munkakor::all() as $munkakor)
                                    <option>{{$munkakor->nev}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <button type="submit" class="btn btn-primary">Létrehozás</button>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pwChangeModal" tabindex="-1" role="dialog" aria-labelledby="pwChangeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pwChangeModalLabel">Jelszó változtatás</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <form method="post" action="{{route('jelszoValtoztatas')}}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="currentPassword">Jelenlegi jelszó</label>
                                <input name="current" type="password" class="form-control" id="currentPassword">
                            </div>
                            <div class="form-group">
                                <label for="newPassword">Új jelszó</label>
                                <input name="new" type="password" class="form-control" id="newPassword">
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Új jelszó ismétlés</label>
                                <input name="confirm" type="password" class="form-control" id="confirmPassword">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                            <button type="submit" class="btn btn-primary">Mentés</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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