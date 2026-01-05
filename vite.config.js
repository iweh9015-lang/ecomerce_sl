// ================================================
// FILE: vite.config.js
// FUNGSI: Konfigurasi bundler untuk compile assets
// ================================================

import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true, // Hot Module Replacement (HMR): Auto-refresh browser saat file .blade.php berubah
        }),
    ],
});