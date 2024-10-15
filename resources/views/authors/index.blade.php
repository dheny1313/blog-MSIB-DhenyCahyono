@extends('layouts.app_blog')

@section('title', 'authors')

@section('content')
<h1>Authors</h1>
<a href="{{ route('authors.create') }}" class="btn btn-primary mb-2">Create author</a>
<div class="list-group">
    {{-- @dd($authors); --}}
    @if (count($authors) >= 0)
    @foreach ($authors as $author)
    <div class="list-group-item justify-content-between align-items-center d-flex">
        <a href="{{ route('authors.show', $author->id) }}">{{ $author->name }}</a>
        <div>
            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" style="display: inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to delete this data?');">
                    Delete
                </button>
            </form>
        </div>
    </div>
    @endforeach
    @else
    <div class="list-group-item jsutify-content-between align-items-center">
        No data
    </div>
    @endif
</div>
@endsection