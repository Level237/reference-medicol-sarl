const scroller = document.getElementById('home-categories-scroller');

if (scroller) {
    const previous = document.getElementById('categories-prev');
    const next = document.getElementById('categories-next');

    const step = () => {
        const card = scroller.querySelector('a');

        if (! card) {
            return 160;
        }

        return card.getBoundingClientRect().width + 16;
    };

    previous?.addEventListener('click', () => {
        scroller.scrollBy({ left: -step(), behavior: 'smooth' });
    });

    next?.addEventListener('click', () => {
        scroller.scrollBy({ left: step(), behavior: 'smooth' });
    });
}
