@extends("layouts.app_blog")
@section('title','show detail user')
@section("content")
<div class="card" style="width:400px">
    <img class="card-img-top" src="img_avatar1.png" alt="Card image">
    <div class="card-body">
        <h4 class="card-title">nama : {{$user->name}}</h4>
        <p class="card-text">email : {{$user->email}}</p>
        <p class="card-text"> password : {{$user->password}}</p>
        <a href="{{route('users.index')}}" class="btn btn-primary">kembali</a>
    </div>
</div>
@endsection