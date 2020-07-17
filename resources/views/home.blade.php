@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="flex-fill">
        @if(session()->has('message'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('message') }}
            </div>
        @endif
        @forelse($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <a href="{{ route('post', $post->id) }}" class="card-title text-decoration-none">
                        <h4>{{ $post->title }}</h4>
                    </a>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $post->user->name }}</h6>
                    <p class="card-text">{{ $post->body }}</p>
                </div>
            </div>
        @empty
            <span>No posts :(</span>
        @endforelse
    </div>
</div>
@endsection
