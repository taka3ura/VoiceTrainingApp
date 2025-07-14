<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'post_id',
    ];

    /**
     * 返信したユーザーを取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * この返信が属する投稿を取得
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
