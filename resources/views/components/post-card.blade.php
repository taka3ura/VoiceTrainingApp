{{--
    このファイルは、一つの投稿（Post）を表示するためのUIコンポーネントです。
    外部から `$post` オブジェクトを受け取って表示します。
--}}
<div class='post' data-post-id="{{ $post->id }}">
    <div class="user_information">
        <a href="{{ route('users.show', ['user' => $post->user->id]) }}" class="flex items-center no-navigate-post">
            <div class="circle"><img src="{{ $post->user->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
            <h2 class='user_name'>{{ $post->user->name }}</h2>
        </a>
        <p class="post-date ml-2 text-sm text-gray-500">{{ $post->created_at->format('Y/m/d H:i') }}</p>
    </div>
    <p class='post_body'>
        <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
        @if ($post->audio_url)
        <audio controls class="no-navigate-post">
            <source src="{{ $post->audio_url }}">
            あなたのブラウザはaudioに対応していません。
        </audio>
        @endif
    </p>
    <div class="post_actions">
        <div class="reply-container">
            <ion-icon name="chatbubble-outline"></ion-icon>
            <p>{{ $post->replies_count }}</p>
        </div>
        <div class="like-container no-navigate-post">
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
        <div class="post_edit no-navigate-post">
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