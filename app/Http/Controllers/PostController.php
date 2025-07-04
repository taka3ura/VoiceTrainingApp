<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PostRequest;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Character; // Characterモデルをインポート

class PostController extends Controller
{
    public function index(Post $post) //インポートしたPostをインスタンス化して$postとして使用。
    {
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit()]);
    }

    public function show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
        //'post'はbladeファイルで使う変数。中身は$postはid=1のPostインスタンス。
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        if ($request->file("audio")) {
            //cloudinaryへ音声を送信し、画像のURLを$audio_urlに代入している
            $audio_url = Cloudinary::upload($request->file('audio')->getRealPath(), ['resource_type' => 'video'])->getSecurePath();
            //dd($audio_url);  //音声のURLを画面に表示
            $input += ['audio_url' => $audio_url];
        }
        $input['user_id'] = Auth::id();
        $post->fill($input)->save();

        // Userに関する処理を追加
        $user = Auth::user(); // 現在のユーザーを取得
        $today = now()->toDateString(); // 今日の日付を取得

        // ユーザーの現在のレベルを、練習日数を増やす前に取得
        $oldLevel = $user->level;

        // 最終処理した日付と今日の日付が異なる場合
        if ($user->last_practice_date !== $today) {
            $user->practice_days += 1; // 練習した日数を1増やす
            $user->last_practice_date = $today; // 最終処理した日付を今日の日付に更新

            // ここでユーザー情報を保存
            $user->save(); // ユーザー情報を保存

            // 練習日数が更新された後の新しいレベルを取得
            $newLevel = $user->level;

            // レベルが上がったかどうかをチェック
            if ($newLevel > $oldLevel) {
                // 新しいレベルで開放されるキャラクターをチェックし、紐付ける
                $unlockableCharacters = Character::where('required_level', '<=', $newLevel)
                    ->get();

                $newlyUnlocked = collect(); // 新しく開放されたキャラクターを格納するコレクション

                foreach ($unlockableCharacters as $character) {
                    // ユーザーがまだこのキャラクターを所有していない場合のみ紐付ける
                    if (!$user->characters->contains($character->id)) {
                        $user->characters()->attach($character->id);
                        $newlyUnlocked->push($character);
                    }
                }
            }
        }

        return redirect('/');
    }


    public function edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        $input['user_id'] = Auth::id();
        $post->fill($input)->save();
        return redirect('/');
    }

    public function delete(Post $post)
    {
        $post->delete();
        return redirect('/');
    }
}
