<x-app-layout>
    <div class='post'>
        <p class='user_name'>{{ $post->user->name }}</p>
        <p class='body'>
            <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
        </p>
        @if ($post->audio_url)
        <audio controls>
            <source src="{{ $post->audio_url }}">
            あなたのブラウザはaudioタグをサポートしていません。
        </audio>
        @endif
        @if ($post->user_id === Auth::id())
        <a href="/posts/{{ $post->id }}/edit">編集</a>
        @endif
    </div>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
</x-app-layout>