@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $post->title }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ $post->user->name }}</h6>
            <p class="card-text">{{ $post->body }}</p>
        </div>
        <hr>
        <div class="card-body">
            <h5 class="card-title">Comments</h5>
            <div class="ml-3">
                @if(session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session()->get('message') }}
                    </div>
                @endif
                @forelse($post->comments as $comment)
                    <div class="mb-2">
                        <h5 class="mb-0">{{ $comment->user->name }}</h5>
                        <p class="mb-0">{{ $comment->body }}</p>
                        <small>
                            <a onclick="like(event, {{ $comment->id }}, {{ $post->id }})" href="#" class="like">{{ $comment->likes }} {{ $comment->likes != 1 ? 'likes' : 'like' }}</a>
                        </small>
                    </div>
                @empty
                    <p>This post has no comments</p>
                @endforelse
                @auth
                    <hr>
                    <form method="POST" action="/comment">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <div class="form-group">
                            <input type="text" class="form-control" name="body" placeholder="Type..">
                        </div>
                        <button type="submit" class="btn btn-primary">Comment</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function like(event, id, post_id) {
            event.preventDefault();
            let button = event.target;
            let data = new FormData();
            data.append('_token', '{{ Session::token() }}');
            data.append('_method', 'PATCH');
            data.append('id', id);
            data.append('post_id', post_id);
            fetch('/comment/like/' + id, {
                method: 'POST',
                body: data
            }).then(function(res) {
                return res.json();
            }).then(function(res) {
                if(parseInt(res) != 1)
                    button.innerText = res + " likes";
                else
                    button.innerText = res + ' like';
            });
        }
    </script>
@endsection