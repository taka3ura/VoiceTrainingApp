<?php

namespace App\Http\Controllers;

use App\Models\User; // Userモデルをインポート
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * 特定のユーザーのプロフィールとその投稿を表示します。
     *
     * @param  User  $user ルートモデルバインディングにより自動的にユーザーが注入されます。
     * @return \Illuminate\View\View
     */
    public function show(User $user): View
    {
        // N+1問題を避けつつ、ユーザーの投稿をページネーションして取得します。
        // 'posts' はUserモデルに定義されたリレーション名と仮定します。
        $posts = $user->posts()->latest()->paginate(10);

        return view('users.show', [
            'user' => $user,
            'posts' => $posts, // ページネーションされた投稿をビューに渡す
        ]);
    }
}
