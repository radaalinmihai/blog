@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex flex-row justify-content-between">
                <h5 class="card-title">{{ $post->title }}</h5>
                @auth
                    @if($post->user_id === auth()->user()->id)
                        <section class="d-flex flex-row">
                            <span role="button" class="material-icons">create</span>
                            <span type="button" role="button" class="material-icons" data-toggle="modal" data-target="#deletePost">delete</span>
                        </section>
                        <div class="modal fade" id="deletePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete this post</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span class="material-icons" aria-hidden="true">close</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this post? This actions is not reversable.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        <form action="/post/{{ $post->id }}/delete" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
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
                        <div class="d-flex likes-container">
                            @auth
                                <span role="button" data-id-comment="{{ $comment->id }}" class="like {{ $comment->isLiked($comment->id) ? 'text-primary' : 'text-dark' }} material-icons">thumb_up</span>
                                <span role="button" data-id-comment="{{ $comment->id }}" class="dislike {{ $comment->isDisliked($comment->id) ? 'text-primary' : 'text-dark' }} material-icons">thumb_down</span>
                            @endauth
                            <span class="@guest text-primary @endguest likes">Likes {{ $comment->likes ?: 0 }}</span>
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
        let likes = document.getElementsByClassName('likes');

        $('.like').click(function(event) {
            event.preventDefault();
            let id = $(this).attr('data-id-comment'),
                elId = $(this).index(this);
            axios.post('/comment/' + id + '/like')
                .then(function() {
                    let dislikeButton = document.getElementsByClassName('dislike')[elId];
                    event.target.classList.add('text-primary');
                    event.target.classList.remove('text-dark');
                    likes[elId].innerText = parseInt(likes[elId].innerText) + 1;
                    dislikeButton.classList.add('text-dark');
                    dislikeButton.classList.remove('text-primary');
                });
        });

        $('.dislike').click(function(event) {
            event.preventDefault();
            let id = $(this).attr('data-id-comment'),
                elId = $(this).index(this);
            axios.post('/comment/' + id + '/dislike', {
                _method: 'DELETE',
            }).then(function() {
                let likeButton = document.getElementsByClassName('like')[elId];
                event.target.classList.add('text-primary');
                event.target.classList.remove('text-dark');
                if(parseInt(likes[elId].innerText) > 0)
                    likes[elId].innerText = parseInt(likes[elId].innerText) - 1;
                likeButton.classList.add('text-dark');
                likeButton.classList.remove('text-primary');
            });
        });
    </script>
@endsection