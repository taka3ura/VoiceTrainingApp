<x-app-layout>
    <div class="new_post">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
            <p class="user_name">{{ Auth::user()->name }}</p>
        </div>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <textarea class="my-textarea" name="post[body]" placeholder="歌ってみた！">{{ old('post.body') }}</textarea>
            </div>
            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
            <div class="audio">
                <input type="file" id="audio" name="audio" accept="audio/*" style="display: none;">
                <label for="audio" class="custom-file-upload">
                    <img src="https://res.cloudinary.com/dee34nq47/image/upload/v1751204819/%E9%9F%B3%E6%A5%BD%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%A2%E3%82%A4%E3%82%B3%E3%83%B3_4_ylfln6.png" alt="Upload Audio" />
                    <p id="file-name">音声ファイル</p>
                </label>
            </div>
            <input type="submit" value="投稿" />
        </form>
    </div>
    <div class='posts'>
        @foreach ($posts as $post)
        <div class='post'>
            <div class="user_information">
                <div class="circle"><img src="{{ $post->user->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
                <h2 class='user_name'>{{ $post->user->name }}</h2>
            </div>
            <p class='body'>
                <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
                @if ($post->audio_url)
                <audio controls>
                    <source src="{{ $post->audio_url }}">
                    あなたのブラウザはaudioに対応していません。
                </audio>
                @endif
            </p>
            <div class="post_actions">
                <div class="like-container">
                    @auth
                    @php
                    $likeUrl = route('posts.like', ['post' => $post->id]);
                    // ★重要: likesCount変数をここで定義し、初期表示に使う
                    $currentLikesCount = $post->likes->count();
                    // 初期表示でいいね済みかどうかもここで確実に判定
                    $isLikedByUserInitial = Auth::user()->likes()->where('post_id', $post->id)->exists();
                    @endphp

                    {{-- いいね済みなら塗りつぶしハート、そうでなければアウトラインハート --}}
                    @if($isLikedByUserInitial)
                    <ion-icon
                        name="heart"
                        class="like-btn cursor-pointer text-pink-500"
                        id="like-icon-{{$post->id}}"
                        data-post-id="{{$post->id}}"
                        data-like-url="{{ $likeUrl }}"></ion-icon>
                    @else
                    <ion-icon
                        name="heart-outline"
                        class="like-btn cursor-pointer"
                        id="like-icon-{{$post->id}}"
                        data-post-id="{{$post->id}}"
                        data-like-url="{{ $likeUrl }}"></ion-icon>
                    @endif

                    {{-- ★いいねカウント表示を定義した変数で確実にする --}}
                    <p class="likes-count" id="likes-count-{{ $post->id }}">{{$currentLikesCount}}</p>
                    @endauth
                </div>
                @if ($post->user_id === Auth::id())
                <div class="post_edit">
                    <a href="/posts/{{ $post->id }}/edit">編集</a>
                    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
    <script>
        function deletePost(id) {
            'use strict'
            if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                document.getElementById(`form_${id}`).submit();
            }
        }
        document.getElementById('audio').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : '音声ファイル';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        // deletePost と audio イベントリスナーはそのまま

        document.addEventListener('DOMContentLoaded', () => {
            // 全ての投稿を含む親要素（例えば .posts クラスの div）にイベントリスナーをアタッチ
            const postsContainer = document.querySelector('.posts');

            if (postsContainer) {
                // 親要素に対して1つだけクリックイベントリスナーを設定
                postsContainer.addEventListener('click', async (e) => {
                    // クリックされた要素、またはその祖先で .like-btn クラスを持つものを探す
                    const iconElement = e.target.closest('.like-btn');

                    // もしクリックされたのが .like-btn (ion-icon) でなければ処理しない
                    if (!iconElement || iconElement.tagName !== 'ION-ICON') {
                        return;
                    }

                    // ここから以前のいいね処理ロジック
                    const postId = iconElement.dataset.postId;
                    const url = iconElement.dataset.likeUrl;

                    if (!postId || !url) {
                        console.error("投稿IDまたはURLが取得できませんでした。", {
                            postId,
                            url,
                            iconElement
                        });
                        alert("いいね処理に必要な情報が不足しています。");
                        return;
                    }

                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

                        const response = await fetch(url, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": csrfToken,
                            },
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || `サーバーエラー: ${response.status}`);
                        }

                        const data = await response.json();

                        // いいね数を更新
                        const likesCountElement = document.getElementById(`likes-count-${postId}`);
                        if (likesCountElement) {
                            likesCountElement.textContent = data.likes_count;
                        } else {
                            console.warn(`likes-count-${postId} の要素が見つかりませんでした。`);
                        }

                        // ハートアイコンの色とタイプを更新
                        if (data.is_liked_by_user) {
                            iconElement.classList.add("text-pink-500");
                            iconElement.setAttribute("name", "heart");
                        } else {
                            iconElement.classList.remove("text-pink-500");
                            iconElement.setAttribute("name", "heart-outline");
                        }
                    } catch (error) {
                        console.error("いいね処理が失敗しました:", error);
                        alert(`いいね処理が失敗しました: ${error.message || '不明なエラー'}`);
                    }
                });
            } else {
                console.error("'.posts' コンテナ要素が見つかりませんでした。イベントリスナーを設定できません。");
            }
        });
    </script>
</x-app-layout>