<?php


namespace App\Traits;


use App\Like;
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
        Like::updateOrCreate([
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

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}