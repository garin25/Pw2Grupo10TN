document.addEventListener('DOMContentLoaded', function() {

    const paisInput = document.getElementById('pais');
    const ciudadInput = document.getElementById('ciudad');
    const mapPopup = document.getElementById('map-popup');
    const closeMapButton = document.getElementById('close-map');

    const latitudInput = document.getElementById('latitud');
    const longitudInput = document.getElementById('longitud');

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

                    latitudInput.value = lat;
                    longitudInput.value = lon;

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
    const fotoPerfilInput = document.getElementById('fotoPerfilInput');
    const fotoPreview = document.getElementById('fotoPreview');

    if (fotoPerfilInput && fotoPreview) {

        fotoPerfilInput.addEventListener('change', function() {

            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    fotoPreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            }
        });
    }
    const form = document.getElementById('contenedor-form-registro');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm-password');
    const passwordError = document.getElementById('password-error');

    if (form && password && confirmPassword && passwordError) {

        form.addEventListener('submit', function(event) {

            if (password.value !== confirmPassword.value) {

                event.preventDefault();

                passwordError.classList.remove('hidden');

                password.classList.add('input-error');
                confirmPassword.classList.add('input-error');

            } else {
                passwordError.classList.add('hidden');
                password.classList.remove('input-error');
                confirmPassword.classList.remove('input-error');
            }
        });
    }
});