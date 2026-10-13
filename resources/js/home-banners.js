const section = document.getElementById('home-banners-section');

if (section) {
    let banners = [];

    try {
        banners = JSON.parse(section.dataset.banners ?? '[]');
    } catch {
        banners = [];
    }

    const feature = document.getElementById('banner-feature');
    const sideTop = document.getElementById('banner-side-top');
    const sideBottom = document.getElementById('banner-side-bottom');
    const slots = [feature, sideTop, sideBottom].filter(Boolean);
    const previous = document.getElementById('banner-prev-btn');
    const next = document.getElementById('banner-next-btn');

    let current = 0;
    let timer = null;

    const paint = (link, banner, animate) => {
        if (! link || ! banner) {
            return;
        }

        const image = link.querySelector('img');

        if (! image) {
            return;
        }

        const apply = () => {
            image.src = banner.src;
            image.alt = banner.title;
            link.href = banner.href;
            image.style.opacity = '1';
        };

        if (! animate || image.src.endsWith(banner.src)) {
            apply();

            return;
        }

        image.style.opacity = '0';
        window.setTimeout(apply, 180);
    };

    const show = (index, animate = true) => {
        if (banners.length < 1) {
            return;
        }

        current = (index + banners.length) % banners.length;

        slots.forEach((slot, offset) => {
            paint(slot, banners[(current + offset) % banners.length], animate);
        });
    };

    const stopAutoplay = () => {
        if (timer) {
            clearInterval(timer);
            timer = null;
        }
    };

    const startAutoplay = () => {
        stopAutoplay();

        if (banners.length < 2) {
            return;
        }

        timer = setInterval(() => show(current + 1), 6000);
    };

    previous?.addEventListener('click', () => {
        show(current - 1);
        startAutoplay();
    });

    next?.addEventListener('click', () => {
        show(current + 1);
        startAutoplay();
    });

    section.addEventListener('mouseenter', stopAutoplay);
    section.addEventListener('mouseleave', startAutoplay);

    show(0, false);
    startAutoplay();
}
