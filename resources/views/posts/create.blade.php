<form action="/posts" method="POST">
    @csrf
    <p>{{ Auth::user()->name }}</p>
    <div class="body">
        <textarea name="post[body]" value="練習したよ！"></textarea>
    </div>
    <input type="submit" value="store" />
</form>
<div class="footer">
    <a href="/posts">戻る</a>
</div>