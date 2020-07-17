<?php


namespace App\Traits;


use App\Like;
use Illuminate\Support\Facades\Auth;

trait Likable
{
    public function like()
    {
        return dd(request()->all());
        Like::updateOrCreate([
            'user_id' => Auth::id()
        ], [
            'user_id' => Auth::id(),
            'liked' => true
        ]);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}