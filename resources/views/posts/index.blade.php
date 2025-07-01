<x-app-layout>
    <div class="new_post">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
            <p class="user_name">{{ Auth::user()->name }}</p>
        </div>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <textarea class="my-textarea" name="post[body]" placeholder="練習したよ！">{{ old('post.body') }}</textarea>
            </div>
            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
            <div class="audio">
                <input type="file" id="audio" name="audio" accept="audio/*" style="display: none;">
                <label for="audio" class="custom-file-upload">
                    <img src="https://res.cloudinary.com/dee34nq47/image/upload/v1751204819/%E9%9F%B3%E6%A5%BD%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%A2%E3%82%A4%E3%82%B3%E3%83%B3_4_ylfln6.png" alt="Upload Audio" />
                    <p id="file-name">音声ファイル</p>
                </label>
            </div>
            <input type="submit" value="投稿" />
        </form>
    </div>
    <div class='posts'>
        @foreach ($posts as $post)
        <div class='post'>
            <div class="user_information">
                <div class="circle"><img src="{{ $post->user->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
                <h2 class='user_name'>{{ $post->user->name }}</h2>
            </div>
            <p class='body'>
                <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
                @if ($post->audio_url)
                <audio controls>
                    <source src="{{ $post->audio_url }}">
                    あなたのブラウザはaudioに対応していません。
                </audio>
                @endif
            </p>
            @if ($post->user_id === Auth::id())
            <div class="post_edit">
                <a href="/posts/{{ $post->id }}/edit">編集</a>
                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $post->id }})">削除</button>
                </form>
            </div>
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
        document.getElementById('audio').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : '音声ファイル';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</x-app-layout>