import './bootstrap';
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
})
