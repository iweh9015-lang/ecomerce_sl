document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('[data-count]')

    counters.forEach(counter => {
        const target = +counter.getAttribute('data-count')
        let current = 0
        const increment = target / 60

        const update = () => {
            current += increment
            if (current < target) {
                if (target > 1000000) {
                    counter.innerText = 'Rp ' + Math.floor(current).toLocaleString('id-ID')
                } else {
                    counter.innerText = Math.floor(current)
                }
                requestAnimationFrame(update)
            } else {
                if (target > 1000000) {
                    counter.innerText = 'Rp ' + target.toLocaleString('id-ID')
                } else {
                    counter.innerText = target
                }
            }
        }

        update()
    })
    // ================================================
    // FILE: resources/js/app.js
    // FUNGSI: Entry point untuk semua JavaScript
    // ================================================

    // Import Bootstrap JS (untuk dropdown, modal, dll)
 

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
})
