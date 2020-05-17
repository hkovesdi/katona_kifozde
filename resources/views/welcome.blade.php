
@extends('app')

@section('content')

<body>
    <nav class="topnav" >
            <ul>
                <li><a class="active" href="#home">Főoldal</a></li>
                <li onclick="myFunction()" class="dropdown"><a href="javascript:void(0)" class="dropbtn">Futárok</a>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="#1">Futar1</a>
                        <a href="#2">Futar2</a>
                        <a href="#3">Futar3</a>
                    </div>
                </li>
                <li><a href="#diagrams">Diagramok</a></li>
                <li class="right"><a href="#logout">Kijelentkezés</a></li>
            </ul>
</nav>
</body>