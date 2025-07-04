<div class="character-width bg-white border-l border-gray-200 p-4 sticky top-0 h-screen">
    <h2 class="text-lg font-bold">キャラクターメニュー</h2>
    <p>やっほー</p>
    <p>練習{{ Auth::user()->practice_days }}日目</p>
    <p>最後に練習したのは{{ Auth::user()->last_practice_date }}</p>
    <p>現在のレベルは{{ Auth::user()->level }}</p>
    <div id="image-carousel" style="width: 90%; margin: 0 auto;">
        @foreach(Auth::user()->currentCharacter->images as $image)
        <img src="{{ asset($image->image_url) }}" alt="{{ Auth::user()->currentCharacter->name }}の画像" class="carousel-image">
        @endforeach
    </div>
</div>