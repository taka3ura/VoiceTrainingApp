<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'profile_description',
        'practice_menu',
        'practice_days',
        'last_practice_date',
        'current_character_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * このユーザーが所有する（アンロック済みの）キャラクターを全て取得します。
     * 多対多のリレーションシップ。
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'user_characters');
    }

    /**
     * このユーザーが現在設定しているキャラクターを取得します。
     * 一対多（逆）のリレーションシップ。
     */
    public function currentCharacter(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'current_character_id');
    }

    public function likes()
    {
        // User / Post has many Likes
        return $this->hasMany(Like::class);
    }


    /**
     * ユーザーの現在のレベルを算出します。（アクセサ）
     * practice_days に基づいてレベルを計算します。
     * 例: 練習日数10日ごとにレベル1アップ
     */
    public function getLevelAttribute(): int
    {
        return floor($this->practice_days / 10) + 1;
    }

    /**
     * モデルの「起動」時に実行されるメソッド。
     * ここでイベントリスナーを登録します。
     */
    protected static function boot()
    {
        parent::boot();

        // ユーザーが新しく作成された（データベースに保存された）後に実行
        static::created(function (User $user) {
            // レベル1のキャラクターを取得
            // シーダーで「ナナ (夢の始まり)」のrequired_levelを1に設定済みであることを前提
            $level1Character = \App\Models\Character::where('required_level', 1)->first();

            if ($level1Character) {
                // ユーザーがまだこのキャラクターを所有していなければ紐付ける
                // 基本的には新規ユーザーなので所有していないはずだが、念のためチェック
                if (!$user->characters->contains($level1Character->id)) {
                    $user->characters()->attach($level1Character->id);
                }
            }
        });
    }
}
