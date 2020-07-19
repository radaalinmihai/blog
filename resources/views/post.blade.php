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
                        <div class="flex-row">
                            <a href="#" onclick="like(event, {{ $comment->id }}, {{ $post->id }})">Like</a>
                            {{ $comment->likes ?: 0 }}
                            <a href="#" onclick="dislike(event, {{ $comment->id }}, {{ $post->id }})">Dislike</a>
                            {{ $comment->dislikes ?: 0 }}
                        </div>
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
            let data = new FormData();
            data.append('_token', '{{ Session::token() }}');
            data.append('id', id);
            data.append('post_id', post_id);
            fetch('/comment/' + id + '/like', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: data
            }).then(function(res) {
                console.log(res);
            })
        }
        function dislike(event, id, post_id) {
            event.preventDefault();
            let data = new FormData();
            data.append('_token', '{{ Session::token() }}');
            data.append('_method', 'DELETE');
            data.append('id', id);
            data.append('post_id', post_id);
            fetch('/comment/' + id + '/dislike', {
                method: 'POST',
                body: data
            });
        }
    </script>
@endsection