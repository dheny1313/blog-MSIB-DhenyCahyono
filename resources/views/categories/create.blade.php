@extends('layouts.app_blog')

@section('title', 'Create Category')

@section('content')
<h1>Create Category</h1>
<a href="{{ route('categories.index') }}" class="btn btn-outline-secondary mb-3">Back</a>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{route('categories.store')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" id="description" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary mt-2">Submit</button>
</form>

@endsection