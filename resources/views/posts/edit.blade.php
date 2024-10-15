@extends('layouts.app_blog')

@section('title', 'Edit post')

@section('content')
<h1>Edit post</h1>
<a href="{{ route('posts.index') }}" class="btn btn-outline-secondary mb-3">Back</a>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('posts.update', $post->id)}}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class=" form-group">
        <label for="title">title</label>
        <input type="text" name="title" id="name" value="{{ old('title') ?? $post->title }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="content">content</label>
        <input type="text" name="content" id="content" class="form-control" value="{{ old('content') ?? $post->content }}">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="category_id" class="form-control">
            <option value="" disabled selected>Pilih Kategori</option>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id', $post->category_id) == $category->id ? ' selected' : ' ' }}>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="author">author</label>
        <select name="author_id" class="form-control">
            <option value="" disabled selected>Pilih Kategori</option>
            @foreach ($authors as $author)
            <option value="{{ $author->id }}"
                {{ old('author_id', $post->author_id) == $author->id ? ' selected' : ' ' }}>
                {{ $author->name }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="image">Upload Image</label>
        <input type="file" name="image" class="form-control">

        @if ($post->image)
        <div class="mt-2">
            <img src="{{ asset('storage/'.$post->image) }}" alt="Current Image" style="max-width: 200px; max-height: 200px;">
        </div>
        @endif
    </div>
    <div class="form-check">
        <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
        <label for="isPublished" class="form-check-label">Publish</label>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>

@endsection