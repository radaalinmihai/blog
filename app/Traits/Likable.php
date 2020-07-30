<?php


namespace App\Traits;


use App\Comment;
use App\Like;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait Likable
{
    public function scopeWithLikes(Builder $query)
    {
        $query->leftJoinSub(
            'select comment_id, sum(liked) likes, sum(!liked) dislikes from likes group by id',
            'likes',
            'likes.comment_id',
            'comments.id'
        );
    }

    public function like($id, $liked = true)
    {
        return Like::updateOrCreate([
            'user_id' => Auth::id(),
            'comment_id' => $id
        ], [
            'liked' => $liked
        ]);
    }

    public function dislike($id)
    {
        return $this->like($id, false);
    }

    public function isLiked($id)
    {
        return Like::where(['comment_id' => $id, 'user_id' => Auth::id()])->first()['liked'];
    }

    public function isDisliked($id)
    {
        return $this->isLiked($id) === 0;
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}