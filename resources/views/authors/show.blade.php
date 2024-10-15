@extends("layouts.app_blog")
@section("content")
<h2>Author</h2>
<p style="font-weight: bolder;">
    {{ old('name') ?? $author->name }}
</p>
<h4>alamat author : </h4>
<p>
    {{old('address') ?? $author->address }}
</p>
<hr>
<a href="{{route('authors.index')}}" class="btn btn-primary">Kembali</a>
@endsection