
@extends('layouts.app_blog')
@section('title', 'Home Page')

@section('content')
@if ($posts->count() > 0)
    @foreach ($posts as $post)
        <div class="card" style="width: 18rem;">
            <h3 class="card-title">{{ $post->title }}</h3>
            @if ($post->image)
            <!-- <img src="{{ URL::asset('storage/'.$post->image) }}" alt="Post image" class="img-thumbnail me-3" style="width: 100px; height: 100px;"> -->
            <img src="{{asset('storage/'.$post->image)}}" alt="Post image" class="img-thumbnail me-3" style="width: 100px; height: 100px;">
            @else
            <img src="https://via.placeholder.com/100" alt="Default Image" class="img-thumbnail me-3" style="width: 100px; height: 100px;">
            @endif
            <div class="card-body p-4">
                <p>in category {{ $post->category->name }}</p>
                <p>in Author {{ $post->author->name }}</p>
                <p>
                    Status:
                    <span class="badge {{ $post->is_published ? 'bg-success' : 'bg-secondary' }}">
                        {{ $post->is_published ? 'Published' : 'Draft' }}
                    </span>
                <p class="card-text">{{ $post->content }}</p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">Lihat Selengkapnya</a>
            </div>
        </div>
    @endforeach
@else
    <h1>Belum ada postingan</h1>
@endif
@endsection
