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
            <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                @csrf
                @method('DELETE')
                <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
            </form>
            @endif
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
    </script>
</x-app-layout>