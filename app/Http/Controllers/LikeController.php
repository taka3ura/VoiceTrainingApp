<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request; // 使われていない場合は削除してもOK
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likePost(Post $post)
    {
        $userId = Auth::id();
        $liked = $post->likes()->where('user_id', $userId)->first();
        $isLikedByUser = false; // 初期値

        if (is_null($liked)) {
            Like::create([
                'user_id' => $userId,
                'post_id' => $post->id,
            ]);
            $isLikedByUser = true; // いいねしたので true
        } else {
            $liked->delete();
            $isLikedByUser = false; // いいね解除したので false
        }

        $likesCount = $post->likes()->count();

        $param = [
            'likes_count' => $likesCount,
            'is_liked_by_user' => $isLikedByUser, // ★この行を追加
        ];

        return response()->json($param);
    }
}
