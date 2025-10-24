document.addEventListener('DOMContentLoaded', function() {

    const paisInput = document.getElementById('pais');
    const ciudadInput = document.getElementById('ciudad');
    const mapPopup = document.getElementById('map-popup');
    const closeMapButton = document.getElementById('close-map');

    let map = null;
    let marker = null;

    function openMapPopup() {
        mapPopup.classList.add('visible');

        setTimeout(function() {
            if (!map) {
                map = L.map('map').setView([20, 0], 2);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                map.on('click', function(e) {
                    const lat = e.latlng.lat;
                    const lon = e.latlng.lng;

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }

                    const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.address) {
                                const address = data.address;

                                const pais = address.country || 'País no encontrado';

                                // Nominatim puede devolver 'city', 'town', 'village', etc. Probamos varias opciones.
                                const ciudad = address.city || address.town || address.village || 'Ciudad no encontrada';

                                paisInput.value = pais;
                                ciudadInput.value = ciudad;

                                closeMapPopup();
                            } else {
                                alert('No se pudo encontrar una dirección para esta ubicación. Por favor, intenta en otro lugar.');
                            }
                        })
                        .catch(error => {
                            console.error('Error al contactar la API de Nominatim:', error);
                            alert('Ocurrió un error al buscar la dirección. Revisa tu conexión a internet.');
                        });
                });
            }

            map.invalidateSize();
        }, 150);
    }

    function closeMapPopup() {
        mapPopup.classList.remove('visible');
    }

    if (paisInput && ciudadInput && mapPopup && closeMapButton) {
        paisInput.addEventListener('click', openMapPopup);
        ciudadInput.addEventListener('click', openMapPopup);
        closeMapButton.addEventListener('click', closeMapPopup);

        mapPopup.addEventListener('click', function(event) {
            if (event.target === mapPopup) {
                closeMapPopup();
            }
        });
    }
});