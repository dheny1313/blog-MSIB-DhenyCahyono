@extends('layouts.app_blog')

@section('title','Users')

@section('content')
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">nama</th>
            <th scope="col">email</th>
            <th scope="col">password</th>
        </tr>
    </thead>
    <tbody>
        @if(count($users )>=0)
        @foreach($users as $user)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td><a href="{{route('users.show',$user->id)}}">{{$user->name}}</a></td>
            <td>{{$user->email}}</td>
            <td>{{$user->password}}</td>
        </tr>
        @endforeach
        @else
        <th>tidak ada data</th>
        @endif
    </tbody>
</table>
@endsection