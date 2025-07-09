// resources/js/post_actions.js

// 削除確認の関数
function deletePost(id) {
    "use strict";
    if (confirm("削除すると復元できません。\n本当に削除しますか？")) {
        document.getElementById(`form_${id}`).submit();
    }
}

// 音声ファイル選択時のファイル名表示
document.getElementById("audio").addEventListener("change", function () {
    const fileName =
        this.files.length > 0 ? this.files[0].name : "音声ファイル";
    document.getElementById("file-name").textContent = fileName;
});

// いいね処理のイベントリスナー
document.addEventListener("DOMContentLoaded", () => {
    const postsContainer = document.querySelector(".posts");

    if (postsContainer) {
        postsContainer.addEventListener("click", async (e) => {
            const iconElement = e.target.closest(".like-btn");

            if (!iconElement || iconElement.tagName !== "ION-ICON") {
                return;
            }

            const postId = iconElement.dataset.postId;
            const url = iconElement.dataset.likeUrl;

            if (!postId || !url) {
                console.error("投稿IDまたはURLが取得できませんでした。", {
                    postId,
                    url,
                    iconElement,
                });
                alert("いいね処理に必要な情報が不足しています。");
                return;
            }

            try {
                // CSRFトークンはBlade側で設定されたmetaタグから取得
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content");

                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(
                        errorData.message ||
                            `サーバーエラー: ${response.status}`
                    );
                }

                const data = await response.json();

                const likesCountElement = document.getElementById(
                    `likes-count-${postId}`
                );
                if (likesCountElement) {
                    likesCountElement.textContent = data.likes_count;
                } else {
                    console.warn(
                        `likes-count-${postId} の要素が見つかりませんでした。`
                    );
                }

                if (data.is_liked_by_user) {
                    iconElement.classList.add("text-pink-500");
                    iconElement.setAttribute("name", "heart");
                } else {
                    iconElement.classList.remove("text-pink-500");
                    iconElement.setAttribute("name", "heart-outline");
                }
            } catch (error) {
                console.error("いいね処理が失敗しました:", error);
                alert(
                    `いいね処理が失敗しました: ${
                        error.message || "不明なエラー"
                    }`
                );
            }
        });
    } else {
        console.error(
            "'.posts' コンテナ要素が見つかりませんでした。イベントリスナーを設定できません。"
        );
    }
});

// deletePost関数をグローバルスコープで利用できるようにエクスポート
window.deletePost = deletePost;
