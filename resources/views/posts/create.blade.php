<x-app-layout>
    <div class="new_post">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
            <p class="user_name">{{ Auth::user()->name }}</p>
        </div>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <textarea class="my-textarea" name=" post[body]" placeholder="歌ってみた！">{{ old('post.body') }}</textarea>
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
    <div class="footer">
        <a href="/">戻る</a>
    </div>
    <script>
        document.getElementById('audio').addEventListener('change', function() {
            const fileName = this.files.length > 0 ? this.files[0].name : '音声ファイル';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</x-app-layout>