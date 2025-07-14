import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/components/character_menu.css",
                "resources/css/components/navigation.css",
                "resources/css/layouts/main_layout.css",
                "resources/css/pages/posts_index.css",
                "resources/css/pages/users_show.css",
                "resources/css/pages/posts_show.css",
                "resources/js/app.js",
                "resources/js/post_actions.js",
                "resources/js/character_menu.js",
            ],
            refresh: true,
        }),
    ],
});
