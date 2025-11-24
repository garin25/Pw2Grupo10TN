document.addEventListener('DOMContentLoaded', function() {
    // Buscamos el elemento del mapa
    const mapContainer = document.getElementById('mapa-perfil');

    if (mapContainer) {
        const latString = mapContainer.getAttribute('data-lat');
        const lngString = mapContainer.getAttribute('data-lng');

        const lat = parseFloat(latString);
        const lng = parseFloat(lngString);

        if (!isNaN(lat) && !isNaN(lng)) {

            const map = L.map('mapa-perfil').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('Ubicación del jugador')
                .openPopup();

            setTimeout(() => { map.invalidateSize(); }, 100);

        } else {
            console.log("Coordenadas inválidas o no encontradas:", latString, lngString);
            mapContainer.style.display = 'none';
        }
    }
});