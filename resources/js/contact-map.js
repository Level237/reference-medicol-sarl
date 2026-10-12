import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

const element = document.getElementById('contact-map');

if (element) {
    const douala = [4.0511, 9.7043];

    const map = L.map(element, {
        scrollWheelZoom: false,
        zoomControl: false,
    }).setView(douala, 13);

    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    }).addTo(map);

    L.marker(douala, {
        title: 'Douala, Cameroun',
        icon: L.divIcon({
            className: '',
            html: '<span class="block h-4 w-4 rounded-full border-[3px] border-white bg-[#029e55] shadow-md"></span>',
            iconSize: [16, 16],
            iconAnchor: [8, 8],
        }),
    }).addTo(map);
}
