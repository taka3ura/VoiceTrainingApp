<div class='post'>
    <p class='user_name'>{{ $post->user->name }}</p>
    <p class='body'>
        <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
    </p>
</div>
<div class="footer">
    <a href="/posts">戻る</a>
</div>