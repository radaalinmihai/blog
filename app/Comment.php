<?php

namespace App;

use App\Traits\Likable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Likable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
