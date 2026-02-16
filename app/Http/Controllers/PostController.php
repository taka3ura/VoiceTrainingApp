<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest; // フォームリクエスト (バリデーション定義)
use App\Models\Post;              // Postモデルをインポート
use App\Models\Character;         // Characterモデルをインポート (ユーザーのレベルアップ処理で使用)
use App\Models\Reply;             // Replyモデルをインポート (Geminiの返信保存に使用)
use App\Models\User;              // Userモデルをインポート (ナナのアカウント取得に使用)
use Illuminate\Support\Facades\Auth;    // 現在認証されているユーザー情報を取得するファサード
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary; // Cloudinary (画像・音声アップロードサービス) のファサード
use App\Services\GeminiService; // ★ 作成したGeminiServiceをインポート！
use Illuminate\Support\Facades\Log;     // デバッグやエラー情報をログファイルに出力するためのファサード

class PostController extends Controller
{

    protected $geminiService;
    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function index()
    {
        $posts = Post::with('user')->withCount('replies')->latest()->paginate();
        return view('posts.index')->with(['posts' => $posts]);
    }

    public function show(Post $post)
    {
        $post->loadCount('replies');
        return view('posts.show')->with(['post' => $post]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request, Post $post)
    {
        $input = $request['post'];
        if ($request->file("audio")) {
            //cloudinaryへ音声を送信し、音声のURLを$audio_urlに代入している
            $audio_url = Cloudinary::upload($request->file('audio')->getRealPath(), ['resource_type' => 'video'])->getSecurePath();
            //dd($audio_url);  //音声のURLを画面に表示
            $input += ['audio_url' => $audio_url];
        }
        $input['user_id'] = Auth::id();
        $post->fill($input)->save();

        // --- ★ ここからGeminiによる自動返信の処理 ---
        // 投稿された文章（body）を取得。もしbodyがなければ空文字列を設定。
        $postedText = $input['body'] ?? '';

        // 投稿文章が空でない場合のみ、Geminiによる返信処理を行う
        if (!empty($postedText)) {
            // Geminiに送るための「プロンプト」（指示文）を作成
            // ユーザーの投稿内容をプロンプトに含めて、適切な返信を生成するように指示
            $prompt = "ユーザーが歌の練習の投稿をしました。その投稿内容を褒めて励ます短いメッセージを作成してください。返信は30文字程度で、ポジティブなトーンでお願いします。若い女の子の口調で。\n\n投稿内容: 「" . $postedText . "」";

            // ★ GeminiServiceの generateText() メソッドを呼び出し、AIからの返信テキストを取得
            // このメソッドは、成功すれば文字列（AIの返信）、失敗すればnullを返す
            $geminiReplyText = $this->geminiService->generateText($prompt);

            // Geminiからの返信が正常に取得できた場合（nullでなかった場合）
            if ($geminiReplyText) {
                // 「ナナ」のアカウントをデータベースから取得
                // シーダーで設定した「nana.gemini@example.com」メールアドレスで検索する
                // これにより、IDが変更されても確実にナナアカウントを特定できる
                $nanaGeminiBot = User::where('email', 'nana@example.com')->first();

                // ナナのアカウントがデータベースで見つかった場合のみ、リプライを保存
                if ($nanaGeminiBot) {
                    // 投稿 ($post) に紐づくリプライとして、新しいリプライを作成・保存
                    // `replies()` はPostモデルで定義したリレーションメソッド
                    $post->replies()->create([
                        'user_id' => $nanaGeminiBot->id, // リプライの送信者としてナナのユーザーIDを設定
                        'body' => $geminiReplyText,       // Geminiが生成した返信テキストを設定
                    ]);
                    // ログに成功メッセージを出力
                    Log::info('Gemini reply by Nana saved for post ID: ' . $post->id);
                } else {
                    // ナナのアカウントが見つからない場合はエラーログを出力
                    Log::error('Nana (Gemini Bot) user with email nana.gemini@example.com not found. Reply could not be saved for post ID: ' . $post->id);
                }
            } else {
                // Geminiが有効な返信を返さなかった場合（例えば、APIエラーやタイムアウトなど）は警告ログを出力
                Log::warning('Gemini did not return a valid reply for post ID: ' . $post->id);
            }
        } else {
            // 投稿文章が空の場合は、Geminiによる返信処理は行わず、ログに出力
            Log::info('Post has no body text, skipping Gemini reply for post ID: ' . $post->id);
        }
        // --- ★ Geminiによる自動返信の処理はここまで ---

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

                if ($newlyUnlocked->isNotEmpty()) {
                    // 新しくアンロックされたキャラクターの中で、最後のキャラクターのIDを取得
                    $lastUnlockedCharacterId = $newlyUnlocked->last()->id;

                    // ユーザーの current_character_id を更新
                    $user->current_character_id = $lastUnlockedCharacterId;
                    $user->save(); // ユーザー情報を再度保存
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
