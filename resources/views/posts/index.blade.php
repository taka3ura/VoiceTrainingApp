<x-app-layout>
    <div class="new_post">
        <div class="user_information">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.png') }}" alt="プロフィール画像"></div>
            <p class="user_name">{{ Auth::user()->name }}</p>
        </div>
        <form action="/posts" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="body">
                <textarea class="my-textarea" name="post[body]" placeholder="歌ってみた！">{{ old('post.body') }}</textarea>
            </div>
            <p class="body__error" style="color:red">{{ $errors->first('post.body') }}</p>
            <div class="audio">
                <input type="file" id="audio" name="audio" accept="audio/mp4,audio/m4a,audio/wav,audio/mp3" style="display: none;"> <label for="audio" class="custom-file-upload">
                    <img src="https://res.cloudinary.com/dee34nq47/image/upload/v1751204819/%E9%9F%B3%E6%A5%BD%E3%83%95%E3%82%A1%E3%82%A4%E3%83%AB%E3%82%A2%E3%82%A4%E3%82%B3%E3%83%B3_4_ylfln6.png" alt="Upload Audio" />
                    <p id="file-name">音声ファイル</p>
                </label>
            </div>
            <button type="submit" class="mt-2 px-2 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                投稿
            </button>
        </form>
    </div>
    <div class='posts'>
        @foreach ($posts as $post)
        <x-post-card :post="$post" />
        @endforeach
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
</x-app-layout>