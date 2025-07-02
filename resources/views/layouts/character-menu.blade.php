<div class="character-width bg-white border-l border-gray-200 p-4 sticky top-0 h-screen">
    <h2 class="text-lg font-bold">キャラクターメニュー</h2>
    <p>やっほー</p>
    <p>練習{{ Auth::user()->practice_days }}日目</p>
    <p>最後に練習したのは{{ Auth::user()->last_practice_date }}</p>
    <div class="mt-auto flex justify-center w-full">
        <img src="https://res.cloudinary.com/dee34nq47/image/upload/v1751433859/1_1_xavnvv.png" alt="キャラクター画像" style="width: 80%;">
    </div>
</div>