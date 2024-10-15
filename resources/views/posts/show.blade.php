@extends("layouts.app_blog")
@section("content")
<h1>judul : </h1>
{{old("posts")??$post->title}}
<hr>
<a href="{{route('posts.index')}}" class="btn btn-primary">Kembali</a>
@endsection