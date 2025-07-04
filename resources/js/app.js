import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll(".carousel-image");
    let currentIndex = 0;
    const intervalTime = 10000; // 10秒ごと

    // 最初の画像を表示する
    if (images.length > 0) {
        images[currentIndex].classList.add("active"); // 最初の画像をアクティブにする
    }

    // 画像を切り替える関数
    function changeImage() {
        // 現在アクティブな画像からactiveクラスを削除（フェードアウト開始）
        images[currentIndex].classList.remove("active");

        // 次の画像のインデックスを計算
        currentIndex = (currentIndex + 1) % images.length;

        // 新しい画像をアクティブにする（フェードイン開始）
        images[currentIndex].classList.add("active");
    }

    // 画像が複数ある場合のみ自動切り替えを開始
    if (images.length > 1) {
        setInterval(changeImage, intervalTime);
    }
});
