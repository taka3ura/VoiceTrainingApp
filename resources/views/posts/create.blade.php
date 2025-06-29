<x-app-layout>
    <form action="/posts" method="POST">
        @csrf
        <p>{{ Auth::user()->name }}</p>
        <div class="body">
            <textarea name="post[body]" placeholder="練習したよ！">{{ old('post.body') }}</textarea>
        </div>
        <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
        <input type="submit" value="投稿" />
    </form>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
</x-app-layout>