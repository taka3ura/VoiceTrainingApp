<div class="character-width bg-white border-l border-gray-200 p-4 sticky top-0 min-h-screen pb-2.5">
    <div class="practice-menu-container">
        <h2 class="text-lg font-bold text-black">練習メニュー</h2>
        @if (Auth::user()->practice_menu)
        <p style="white-space: pre-wrap; color: black;">{!! Auth::user()->practice_menu !!}</p>
        @else
        <p>まだ練習メニューが設定されていません。</p>
        @endif
        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            編集
        </x-nav-link>
    </div>
    <form action="/posts" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="body">
            <input type="hidden" name="post[body]" value="本日の練習完了！">
        </div>
        <input type="submit" value="練習完了" class="complete-practice-button" />
    </form>
    <p>やっほー</p>
    <p>練習{{ Auth::user()->practice_days }}日目</p>
    <p>最後に練習したのは{{ Auth::user()->last_practice_date }}</p>
    <p>現在のレベルは{{ Auth::user()->level }}</p>
    <div id="image-carousel">
        @foreach(Auth::user()->currentCharacter->images as $image)
        <img src="{{ asset($image->image_url) }}" alt="{{ Auth::user()->currentCharacter->name }}の画像" class="carousel-image">
        @endforeach
    </div>
</div>