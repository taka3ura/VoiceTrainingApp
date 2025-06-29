<x-app-layout>
    <div class="user_information">
        <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
        <p class="user_name">{{ Auth::user()->name }}</p>
    </div>
    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="body">
            <textarea name="post[body]" placeholder="練習したよ！">{{ old('post.body') }}</textarea>
        </div>
        <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
        <div class="audio">
            <input type="file" name="audio" accept="audio/*">
        </div>
        <input type="submit" value="投稿" />
    </form>
    <div class="footer">
        <a href="/">戻る</a>
    </div>
</x-app-layout>