document.addEventListener('DOMContentLoaded', function() {

    const paisInput = document.getElementById('pais');
    const ciudadInput = document.getElementById('ciudad');
    const inputLat = document.getElementById('latitud');
    const inputLng = document.getElementById('longitud');
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
                                if (inputLat) inputLat.value = lat;
                                if (inputLng) inputLng.value = lon;

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

document.addEventListener('DOMContentLoaded', () => {

    // DETECTAR LOCALHOST
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {

        console.log("🚀 MODO LOCAL DETECTADO: Auto-completando formulario...");

        const inputPais = document.getElementById('pais');
        const inputCiudad = document.getElementById('ciudad');
        // Si tienes inputs ocultos para coordenadas, búscalos también
         const inputLat = document.getElementById('latitud');
         const inputLng = document.getElementById('longitud');

        if (inputPais && inputCiudad) {
            // 1. LLENAR VALORES (Lo que se envía al PHP)
            inputPais.value = "Argentina";
            inputCiudad.value = "Buenos Aires";

            // 2. LLENAR COORDENADAS FIJAS (Importante para que no falle la BBDD)
            // Ponemos las coordenadas del Obelisco por ejemplo
            if (inputLat) inputLat.value = "-34.6037";
            if (inputLng) inputLng.value = "-58.3816";

            // 3. ESTILO VISUAL (Para que sepas que es automático)
            const estiloAlerta = "background-color: #fff9c4; border: 2px solid orange; font-weight: bold;";
            inputPais.style.cssText = estiloAlerta;
            inputCiudad.style.cssText = estiloAlerta;

        }
    }
});