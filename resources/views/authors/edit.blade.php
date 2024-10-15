@extends('layouts.app_blog')

@section('title', 'Create author')

@section('content')
<h1>Create author</h1>
<a href="{{ route('authors.index') }}" class="btn btn-outline-secondary mb-3">Back</a>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('authors.update', $author->id)}}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') ?? $author->name }}" class="form-control">
    </div>
    <div class="form-group">
        <label for="address">address</label>
        <input type="text" name="address" id="address" class="form-control" value="{{ old('address') ?? $author->address }}">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>

@endsection