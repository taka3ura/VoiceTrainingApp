<x-app-layout>
    <h1 class="title">編集画面</h1>
    <div class="content">
        <form action="/posts/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class='content__body'>
                <textarea name="post[body]">{{ $post->body }}</textarea>
            </div>
            <input type="submit" value="保存">
        </form>
    </div>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
</x-app-layout>