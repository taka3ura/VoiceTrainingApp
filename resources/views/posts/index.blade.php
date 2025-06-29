<x-app-layout>
    <div class='posts'>
        @foreach ($posts as $post)
        <div class='post'>
            <div class="user_information">
                <img id="preview" src="{{ $post->user->image ?? asset('default-image.jpg') }}" alt="User Image">

                <h2 class='user_name'>{{ $post->user->name }}</h2>
            </div>
            <p class='body'>
                <a href="/posts/{{ $post->id }}">{{ $post->body }}</a>
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
    </script>
</x-app-layout>