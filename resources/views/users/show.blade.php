<x-app-layout>
    <!-- ユーザー情報 -->
    <div class="profile">
        <div class="user_information">
            <div class="circle_show"><img src="{{ $user->image ?? asset('default-image.jpg') }}" alt="{{ $user->name }}のプロフィール画像"></div>
            <h2 class='user_name_show'>{{ $user->name }}</h2>
        </div>
        <p class="mt-2 text-gray-700">{{ $user->profile_description ?? 'プロフィール文はまだありません。' }}</p>
    </div>
    <!-- ユーザーの投稿一覧 -->
    <div class="user_posts">
        @if ($posts->isEmpty())
        <p class="text-gray-600">まだ投稿がありません。</p>
        @else
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
        @endif
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</x-app-layout>