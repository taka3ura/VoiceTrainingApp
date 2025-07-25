<x-app-layout>
    <!-- 選択されたポストを表示 -->
    <x-post-card :post="$post" />
    {{-- 返信投稿フォーム --}}
    @auth {{-- ログインしているユーザーのみフォームを表示 --}}
    <div class="reply-form reply">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.png') }}" alt="プロフィール画像"></div>
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
</x-app-layout>