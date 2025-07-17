<x-app-layout>
    <h1 class="title">編集画面</h1>
    <div class="edit_post">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
            <p class="user_name">{{ Auth::user()->name }}</p>
        </div>
        <div class="body">
            <form action="/posts/{{ $post->id }}" method="POST">
                @csrf
                @method('PUT')
                <!-- 本文の編集 -->
                <div class='content__body'>
                    <textarea class="my-textarea" name="post[body]">{{ old('post.body', $post->body) }}</textarea>
                </div>
                @error('post.body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if ($post->audio_url)
                <audio controls>
                    <source src="{{ $post->audio_url }}">
                    あなたのブラウザはaudioに対応していません。
                </audio>
                @endif
                <input type="submit" value="保存">
            </form>
        </div>
    </div>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
</x-app-layout>