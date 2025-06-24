<x-app-layout>
    <h1>投稿一覧</h1>
    <div class='posts'>
        @foreach ($posts as $post)
        <div class='post'>
            <h2 class='user_name'>{{ $post->user->name }}</h2>
            <p class='body'>
                <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
            </p>
            @if ($post->user_id === Auth::id())
            <a href="/posts/{{ $post->id }}/edit">編集</a>
            @endif
        </div>
        @endforeach
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
</x-app-layout>