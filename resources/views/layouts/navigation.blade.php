<div class="hidden md:flex flex-col justify-between custom-width bg-white border-r border-gray-200 p-3 sticky top-0 h-screen">
    {{-- ▼変更点: 上部にロゴとリンク --}}
    <div>
        {{-- 変更点:ナビゲーションリンク（縦並び --}}
        <div class="flex flex-col space-y-3">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                ダッシュボード
            </x-nav-link>
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                プロフィール
            </x-nav-link>
            <x-nav-link href="/" :active="request()->is('/')">
                投稿一覧
            </x-nav-link>
            <x-nav-link href="/posts/create" :active="request()->is('posts/create')">
                新規投稿
            </x-nav-link>
        </div>
        {{-- ユーザーアイコン --}}
        <div class="flex items-center space-x-2 mb-6">
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
        </div>

    </div>
    {{-- 変更点: 下部にログアウトボタン --}}
    <div>
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
            <div class="circle"><img src="{{ Auth::user()->image ?? asset('default-image.jpg') }}" alt="プロフィール画像"></div>
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