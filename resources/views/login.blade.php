<!DOCTYPE html>
@extends('app')
@section('content')

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    
    <div class="login-page">
    <img src="/photos/kiskakas_logo.png" alt="Kiskakas Vendeglo" class="loginlogo">
        <div class="form">
            <form action="{{route('login')}}" method="post">
                @csrf
                <input type="text" name="username" placeholder="Felhasználónév" class="logininput">
                <input type="password" name="password" placeholder="Jelszó" class="logininput">
                <button type="submit" class="loginbutton buttonhover">Belépés</button>
            </form>
        </div>
    </div>

</body>
@stop