import './bootstrap';
// ================================================
// FILE: resources/js/app.js
// FUNGSI: Entry point untuk semua JavaScript
// ================================================

// Import Bootstrap JS (untuk dropdown, modal, dll)
import * as bootstrap from "bootstrap";

// Simpan ke window agar bisa diakses global
window.bootstrap = bootstrap;

// ================================================
// CUSTOM JAVASCRIPT
// ================================================

// Flash Message Auto-dismiss
document.addEventListener("DOMContentLoaded", function () {
    // Auto close alert setelah 5 detik
    const alerts = document.querySelectorAll(".alert-dismissible");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});