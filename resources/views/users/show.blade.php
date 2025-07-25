<x-app-layout>
    <!-- ユーザー情報 -->
    <div class="profile">
        <div class="user_information">
            <div class="circle_show"><img src="{{ $user->image ?? asset('default-image.jpg') }}" alt="{{ $user->name }}のプロフィール画像"></div>
            <h2 class='user_name_show'>{{ $user->name }}</h2>
        </div>
        <p>{!! nl2br(e($user->profile_description ?? 'プロフィール文はまだありません。')) !!}</p>
        <p>練習{{ $user->practice_days }}日目</p>
        <p>最後に練習したのは{{ $user->last_practice_date }}</p>
        <p>現在のレベルは{{ $user->level }}</p>
        <div class="practice-menu-container-profile">
            <h2 class="text-lg font-bold text-black">練習メニュー</h2>
            @if ($user->practice_menu)
            <p style="white-space: pre-wrap; color: black;">{!! $user->practice_menu !!}</p>
            @else
            <p>まだ練習メニューが設定されていません。</p>
            @endif
        </div>
    </div>
    <!-- ユーザーの投稿一覧 -->
    <div class="user_posts">
        @if ($posts->isEmpty())
        <p class="text-gray-600">まだ投稿がありません。</p>
        @else
        @foreach ($posts as $post)
        <x-post-card :post="$post" />
        @endforeach
        @endif
    </div>
    <div class='paginate'>
        {{ $posts->links() }}
    </div>
</x-app-layout>