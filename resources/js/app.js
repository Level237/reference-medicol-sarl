// Alpine n'est chargé que dans l'espace d'administration.
const startAdminPreview = () => {
    if (! document.body?.hasAttribute('data-admin')) {
        return;
    }

    import('alpinejs').then(({ default: Alpine }) => {
        window.Alpine = Alpine;
        Alpine.start();
    });
};

startAdminPreview();

if (document.getElementById('contact-map')) {
    import('./contact-map.js');
}

if (document.getElementById('home-banners-section')) {
    import('./home-banners.js');
}

if (document.getElementById('home-categories-scroller')) {
    import('./home-categories.js');
}
