<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
    public function store(Request $request, Post $post)
    {
        // 1. バリデーション
        $request->validate([
            'body' => 'required|string|max:255', // 返信内容のバリデーション
        ]);

        // 2. 返信の作成と保存
        // $post->replies() は Post モデルのリレーションシップ (hasMany) を利用
        // create() メソッドで新しいReplyモデルを作成し、自動的に post_id が設定される
        $reply = $post->replies()->create([
            'body' => $request->body,
            'user_id' => Auth::id(), // 現在認証されているユーザーのIDを設定
        ]);

        return redirect()->route('show', $post);
    }

    public function destroy(Post $post, Reply $reply)
    {
        // 1. 認可 (Authorization)
        // 返信の投稿者本人だけが削除できるようにチェックします。
        // これが最も基本的なセキュリティチェックです。
        if (Auth::id() !== $reply->user_id) {
            // 権限がない場合、403 Forbidden エラーを返す
            abort(403, 'Unauthorized action. You are not authorized to delete this reply.');
        }

        // 2. 返信が、指定された投稿に属しているかを確認 (Optional, but good for robustness)
        // URLのpost_idと、replyのpost_idが一致しない場合はエラーにする
        if ($reply->post_id !== $post->id) {
            abort(404, 'Reply not found in this post.');
        }

        // 3. 返信の削除
        $reply->delete();

        // 4. 投稿詳細ページにリダイレクト
        return redirect()->route('show', $post);
    }
}
