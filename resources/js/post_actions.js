// resources/js/post_actions.js

// 削除確認の関数 (グローバルスコープで利用可能にする)
window.deletePost = function (id) {
    "use strict";
    if (confirm("削除すると復元できません。\n本当に削除しますか？")) {
        document.getElementById(`form_${id}`).submit();
    }
};

// DOMContentLoadedイベントで全ての初期化処理を実行
document.addEventListener("DOMContentLoaded", () => {
    // ------------------------------------
    // 音声ファイル選択時のファイル名表示
    // ------------------------------------
    const audioInput = document.getElementById("audio");
    if (audioInput) {
        audioInput.addEventListener("change", function () {
            const fileName =
                this.files.length > 0 ? this.files[0].name : "音声ファイル";
            document.getElementById("file-name").textContent = fileName;
        });
    }

    // ------------------------------------
    // いいね処理のイベントリスナー（イベントデリゲーション）
    // ------------------------------------
    document.body.addEventListener("click", async (e) => {
        const iconElement = e.target.closest(".like-btn");

        // いいねボタンでなければ処理しない
        if (!iconElement || iconElement.tagName !== "ION-ICON") {
            return;
        }

        // クリックイベントの伝播を停止
        // これにより、このクリックが親要素（例: 投稿全体のクリックリスナー）に伝わらないようにする
        e.stopPropagation();

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
                    errorData.message || `サーバーエラー: ${response.status}`
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
                `いいね処理が失敗しました: ${error.message || "不明なエラー"}`
            );
        }
    });
    // ------------------------------------
    // 投稿全体クリックでの詳細ページ遷移
    // ------------------------------------
    const posts = document.querySelectorAll(".post");

    posts.forEach((post) => {
        post.addEventListener("click", function (event) {
            const target = event.target;

            // クリックされた要素が、特定の操作を必要とする要素（またはその子孫）であれば、
            // 投稿詳細ページへの遷移は行わない
            // - no-navigate-post クラスを持つ要素（ユーザーアイコン/名前、いいねコンテナ、編集/削除）
            // - Aタグ（既存の本文リンク）
            // - BUTTONタグ（削除ボタンなど）
            // - INPUTタグ（ファイル選択など）
            // - AUDIOタグ（オーディオプレイヤー）
            if (
                target.closest(".no-navigate-post") ||
                target.tagName === "A" ||
                target.tagName === "BUTTON" ||
                target.tagName === "INPUT" ||
                target.tagName === "AUDIO"
            ) {
                return; // 何もしないで終了
            }

            // それ以外の場所をクリックした場合、投稿詳細ページへ遷移
            const postId = this.dataset.postId;
            if (postId) {
                window.location.href = `/posts/${postId}`;
            }
        });
    });
});
