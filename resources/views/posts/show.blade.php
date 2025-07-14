<x-app-layout>
    <div class='post'>
        <div class="user_information">
            {{-- ユーザーのアイコンと名前にリンクを追加 --}}
            <a href="{{ route('users.show', ['user' => $post->user->id]) }}" class="flex items-center"> {{-- flex items-centerを追加して配置を保つ（任意） --}}
                <div class="circle"><img src="{{ $post->user->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
                <h2 class='user_name'>{{ $post->user->name }}</h2>
            </a>
            <p class="post-date ml-2 text-sm text-gray-500">{{ $post->created_at->format('Y/m/d H:i') }}</p>
        </div>
        <p class='body'>
            {{ $post->body }}
        </p>
        @if ($post->audio_url)
        <audio controls>
            <source src="{{ $post->audio_url }}">
            あなたのブラウザはaudioタグをサポートしていません。
        </audio>
        @endif
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
    {{-- 返信投稿フォーム --}}
    @auth {{-- ログインしているユーザーのみフォームを表示 --}}
    <div class="reply-form reply">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
            <p class="user_name">{{ Auth::user()->name }}</p>
        </div>
        <form action="{{ route('posts.replies.store', $post) }}" method="POST">
            @csrf
            <div class="mb-4 reply-body">
                <textarea
                    name="body"
                    placeholder="返信内容を入力してください"
                    class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    rows="3"
                    required></textarea>
                @error('body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                返信する
            </button>
        </form>
    </div>
    @endauth
    {{-- 返信一覧 --}}
    <div class="replies-list">
        @foreach ($post->replies as $reply) {{-- Postモデルにrepliesリレーションシップが定義されていることを前提 --}}
        <div class="reply-item reply">
            {{-- 返信者のアイコンと名前にリンク --}}
            <div class="user_information">
                <a href="{{ route('users.show', ['user' => $reply->user->id]) }}" class="flex items-center no-navigate-post">
                    <div class="circle"><img src="{{ $reply->user->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
                    <h2 class='user_name'>{{ $reply->user->name }}</h2>
                </a>
                <p class="reply-date ml-2 text-sm text-gray-500">{{ $reply->created_at->format('Y/m/d H:i') }}</p>
            </div>
            <p class="text-gray-700 ml-10">{{ $reply->body }}</p>
            @auth
            @if (Auth::id() === $reply->user_id) {{-- ログインユーザーが返信の投稿者と一致する場合のみ表示 --}}
            <div class="flex justify-end mt-2">
                <form action="{{ route('posts.replies.destroy', ['post' => $post->id, 'reply' => $reply->id]) }}" method="POST" onsubmit="return confirm('本当にこの返信を削除しますか？');">
                    @csrf
                    @method('DELETE') {{-- DELETEメソッドを使用することを指定 --}}
                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">削除</button>
                </form>
            </div>
            @endif
            @endauth
        </div>
        @endforeach
    </div>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</x-app-layout>