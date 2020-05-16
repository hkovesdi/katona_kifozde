
@extends('app')

@section('content')
<p>You need to log in bro</p>
<form action="{{route('login')}}" method="post">
    @csrf
    <input type="text" name="username" placeholder="Username">
    <input type="password" name="password" placeholder="Password">
    <button type="submit">Submit</button>
</form>