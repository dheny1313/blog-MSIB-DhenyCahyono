@extends("layouts.app_blog")
@section("content")
<h2>Judul kategori :</h2>
<p style="font-weight: bolder;">
    {{ old('name') ?? $category->name }}
</p>
<h4>Deskripsi kategori : </h4>
<p>
    {{old('description') ?? $category->description }}
</p>
<hr>
<a href="{{route('categories.index')}}" class="btn btn-primary">Kembali</a>
@endsection