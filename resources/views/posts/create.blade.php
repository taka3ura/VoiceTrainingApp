<form action="/posts" method="POST">
    @csrf
    <p>{{ Auth::user()->name }}</p>
    <div class="body">
        <textarea name="post[body]" placeholder="練習したよ！">{{ old('post.body') }}</textarea>
    </div>
    <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
    <input type="submit" value="store" />
</form>
<div class="footer">
    <a href="/posts">戻る</a>
</div>