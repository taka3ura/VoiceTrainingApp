<div class="hidden md:flex flex-col justify-between custom-width bg-white border-r border-gray-200 p-3 sticky top-0 h-screen">

    {{-- 上部のグループ：ナビゲーションリンク群 --}}
    <div class="flex flex-col space-y-16"> {{-- 各ナビリンク間のスペースを確保 --}}
        <div class="app-branding mb-4 p-2">
            <h2 class="text-2xl text-center">うたプラ</h2>
        </div>
        <x-nav-link href="/" :active="request()->is('/')" class="flex items-center space-x-2">
            <ion-icon name="home-outline" size="large"></ion-icon>
            <span>投稿一覧</span>
        </x-nav-link>
        <x-nav-link href="/posts/create" :active="request()->is('posts/create')" class="flex items-center space-x-2">
            <ion-icon name="create-outline" size="large"></ion-icon>
            <span>投稿する</span>
        </x-nav-link>
        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')" class="flex items-center space-x-2">
            <ion-icon name="person-outline" size="large"></ion-icon>
            <span>プロフィール編集</span>
        </x-nav-link>
    </div>

    {{-- 下部のグループ：ユーザーアイコンとログアウトボタン --}}
    {{-- これらが画面の一番下に固定されるように配置される --}}
    <div class="flex flex-col space-y-3"> {{-- ユーザーアイコンとログアウトボタン間のスペースを確保 --}}
        {{-- ユーザーアイコン --}}
        <a href="{{ route('users.show', Auth::user()->id) }}" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded p-2">
            <div class="circle">
                <img src="{{ Auth::user()->image ?? asset('default-image.png') }}" alt="プロフィール画像">
            </div>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-left w-full px-4 py-2 text-red-500 hover:bg-red-100 rounded">
                ログアウト
            </button>
        </form>
    </div>

</div>
{{-- ▼変更点: モバイル表示用のナビゲーション --}}
<nav x-data="{ open: false }" class="md:hidden bg-white border-b border-gray-100 custom-width">
    <div class="px-4 py-2 flex justify-between items-center">
        {{-- ロゴ・アプリ名 --}}
        <div class="flex items-center space-x-2 min-w-0 overflow-hidden">
            <img src="{{ Auth::user()->image ?? asset('default-image.png') }}" alt="プロフィール画像" class="h-8 w-8 rounded-full">
        </div>
        {{-- ハンバーガーメニュー --}}
        <button @click="open = ! open" class="ms-auto p-2 rounded-md text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    {{-- 変更点: モバイル用のメニュー展開 --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden px-4 pb-4">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            ダッシュボード
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            プロフィール
        </x-responsive-nav-link>
        <x-responsive-nav-link href="/posts" :active="request()->is('posts')">
            投稿一覧
        </x-responsive-nav-link>
        <x-responsive-nav-link href="/posts/create" :active="request()->is('posts/create')">
            新規投稿
        </x-responsive-nav-link>

        {{-- 変更点: モバイル用ログアウトボタン --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                ログアウト
            </x-responsive-nav-link>
        </form>
    </div>
</nav>