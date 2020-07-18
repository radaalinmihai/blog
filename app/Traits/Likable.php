<?php


namespace App\Traits;


use App\Like;
use Illuminate\Database\Eloquent\Builder;

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

    public function like($id, $user_id)
    {
        Like::updateOrCreate([
            'user_id' => $user_id,
            'comment_id' => $id
        ], [
            'liked' => true
        ]);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}