const ruleta = document.querySelector('.ruleta');
const btnGirar = document.getElementById('btn-girar');
const contenedorRuleta = document.getElementById('contenedor-ruleta');
const contenedorPreguntas = document.getElementById('contenedor-preguntas');
const botonesRespuestas = document.querySelectorAll('#preguntas-inf .btn');
const contenedorPerder = document.getElementById('contenedor-partidaPerdida');
const botonVolver = document.getElementById('volver');
const botonInicio = document.getElementById('inicio');
const timer = document.getElementById('timer');

let rtaCorrecta = null; // guardamos la rta correcta para no tener que ir devuelta hasta la bbdd
let btnRtaCorrecta = null; // id= a,b,c o d
let preguntaId = null;
let idrespuestaCorrecta;
let puntaje = null;

contenedorRuleta.classList.add('visible');
contenedorPreguntas.classList.add('oculto');
contenedorPerder.classList.add('oculto');


const numSectores = document.querySelectorAll('.imagen-sector').length;
const gradosPorSector = 360 / numSectores;
let anguloAcumulado = 0;



// funcion de giro de ruleta
function girarRuleta() {
    ruleta.classList.remove('girando');
    btnGirar.disabled = true;

    const sectorGanadorIndex = Math.floor(Math.random() * numSectores);
    const todosLosSectores = document.querySelectorAll('.imagen-sector');
    const sectorGanadorElemento = todosLosSectores[sectorGanadorIndex];
    const categoriaGanadora = sectorGanadorElemento.dataset.nombreCategoria;
    const rutaImagenGanadora = sectorGanadorElemento.dataset.rutaImagen;

    const anguloDeseadoFinal = sectorGanadorIndex * gradosPorSector + gradosPorSector / 2;

    const anguloActualVisual = anguloAcumulado % 360;

    let anguloNecesario = anguloDeseadoFinal - anguloActualVisual;

    if (anguloNecesario < 0) {
        anguloNecesario += 360;
    }

    const girosCompletos = 5;
    const anguloTotalDeGiro = (girosCompletos * 360) + anguloNecesario;

    anguloAcumulado += anguloTotalDeGiro;

    ruleta.style.transform = `rotate(-${anguloAcumulado}deg)`;
    ruleta.classList.add('girando');

    //categoria
    setTimeout(() => {
        btnGirar.disabled = false;
        const rutaImagen = rutaImagenGanadora;

        Swal.fire({
            title: `¡Categoría ${categoriaGanadora}!`,
            text: "¡Prepárate para responder la pregunta!",
            imageUrl: rutaImagen,
            imageHeight: 100,
            confirmButtonText: "¡Vamos!",
            draggable: false
        }).then(() => {
            cambiarAContenedorPregunta()
            traerPregunta(categoriaGanadora);
        });

    }, 5000);
}
btnGirar.addEventListener('click', girarRuleta);

function cambiarAContenedorRuleta() {
    contenedorPreguntas.classList.remove('visible');
    contenedorPreguntas.classList.add('oculto');
    contenedorRuleta.classList.remove('oculto');
    contenedorRuleta.classList.add('visible');
}
function cambiarAContenedorPregunta() {
    contenedorRuleta.classList.remove('visible');
    contenedorRuleta.classList.add('oculto');
    contenedorPreguntas.classList.remove('oculto');
    contenedorPreguntas.classList.add('visible');
}
function cambiarAPartidaPerdida() {
    console.log(puntaje);
    contenedorPreguntas.classList.remove('visible');
    contenedorPreguntas.classList.add('oculto');
    contenedorPerder.querySelector("#puntaje").textContent += puntaje;
    contenedorPerder.classList.remove('oculto');
    contenedorPerder.classList.add('visible');
}


/*function respuestaCorrecta() {
    Swal.fire({
        title: "¡Respuesta correcta!",
        text: "¡Sigue así!",
        icon: "success",
        draggable: false,
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        cambiarAContenedorRuleta();
    });
}*/

function respuestaCorrecta() {
    Swal.fire({
        title: "¡Respuesta correcta!",
        text: "¡Sigue así!",
        icon: "success",
        draggable: false,

        // --- Modificaciones Clave ---
        // 1. Eliminamos 'timer' y 'showConfirmButton: false'
        showConfirmButton: true, // Habilitamos el botón principal
        confirmButtonText: 'Continuar', // Texto para la acción principal

        // 2. Agregamos el botón secundario "Reportar"
        showDenyButton: true, // Muestra un segundo botón
        denyButtonText: 'Reportar', // El texto que pediste
        // ---------------------------

    }).then((result) => {
        // --- Manejo de la Lógica ---
        if (result.isConfirmed) {
            // Se presiona el botón 'Continuar'
            cambiarAContenedorRuleta();
            restablecerRespuestasBoton();
        } else if (result.isDenied) {
            // Se presiona el botón 'Reportar'
            crearReporte();
            cambiarAContenedorRuleta();
            restablecerRespuestasBoton();
        }
        // Si se cierra el modal sin hacer clic (result.dismiss), no ocurre nada
    });
}

function restablecerRespuestasBoton() {

    for (let i = 0; i < botonesRespuestas.length; i++) {

        botonesRespuestas[i].classList.remove('respuestaCorrectaAnimation');
        botonesRespuestas[i].classList.remove('respuestaIncorrecta');

    }

}

function respuestaIncorrecta() {
    Swal.fire({
        title: "¡Respuesta incorrecta!",
        text: "¡Game Over!",
        icon: "error",
        draggable: false,

        // --- Modificaciones Clave ---
        // 1. Eliminamos 'timer' y 'showConfirmButton: false'
        showConfirmButton: true, // Habilitamos el botón principal
        confirmButtonText: 'Continuar', // Texto para la acción principal

        // 2. Agregamos el botón secundario "Reportar"
        showDenyButton: true, // Muestra un segundo botón
        denyButtonText: 'Reportar', // El texto que pediste
        // ---------------------------

    }).then((result) => {
        // --- Manejo de la Lógica ---
        if (result.isConfirmed) {
            // Se presiona el botón 'Continuar'
            cambiarAPartidaPerdida();
        } else if (result.isDenied) {
            // Se presiona el botón 'Reportar'
            crearReporte();
            cambiarAPartidaPerdida();
        }
        // Si se cierra el modal sin hacer clic (result.dismiss), no ocurre nada
    });
}

/*function respuestaIncorrecta(){
    Swal.fire({
        title: "Respuesta incorrecta",
        text: "¡Game over!",
        icon: "error",
        draggable: false,
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        // crear estadisticas partida y boton volver al home
        cambiarAPartidaPerdida()
    });
}*/

function tiempoAcabado(){
    Swal.fire({
        title: "Tiempo acabado",
        text: "¡Game over!",
        icon: "error",
        draggable: false,
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        // crear estadisticas partida y boton volver al home
        cambiarAPartidaPerdida()
    });
}

    function traerPregunta(categoria) {
        const url = '/juego/pregunta';
        const xhttp = new XMLHttpRequest();
        // Revisar como pasar los datos:
        const datosParaEnviar = {
            "categoria": categoria
        };

        const postData = JSON.stringify(datosParaEnviar);
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                const respuestaJSON = this.responseText;

                try {

                    const data = JSON.parse(respuestaJSON);
                    console.log(data);
                    const ok = data.ok;

                    if (ok === true) {
                        vistaDeCarga()
                        // fijarse como se recibe el json capaz es data.id y asi
                        const pregunta = data.pregunta;
                        preguntaId = pregunta.preguntaId;
                        const respuestas = data.respuestas;
                        const tiempo = data.tiempo;
                        console.log(data.time)
                        respuestas.forEach(respuesta => {
                            if (respuesta.esCorrecta) {
                                rtaCorrecta = respuesta;
                                idrespuestaCorrecta = respuesta.id_respuesta;
                            }
                        })

                        const descPregunta = document.getElementById("preguntas-descripcion");
                        descPregunta.textContent = pregunta.enunciado;
                        for (let i = 0; i < botonesRespuestas.length; i++) {
                            botonesRespuestas[i].id = respuestas[i].id_respuesta;
                            if (respuestas[i].esCorrecta) {
                                btnRtaCorrecta = botonesRespuestas[i].id;
                            }
                            botonesRespuestas[i].textContent = respuestas[i].respuestaTexto;
                            botonesRespuestas[i].onclick = () => {
                                //console.log(botonesRespuestas[i].id);
                                timer.classList.add('oculto');
                                clearInterval(temporizador);
                                contestarPregunta(botonesRespuestas[i].id);
                            };
                        }

                        timerVista(tiempo);
                    }
                    if (ok === false) {
                        Swal.fire({
                            title: 'Error!',
                            text: data.error,
                            icon: 'error',
                            confirmButtonText: 'Volver'
                        })
                    }


                } catch (error) {
                    console.error("Error al parsear la respuesta JSON:", error);
                }

            }

        };

        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-Type", "application/json");

        xhttp.send(postData);

    }

// Hay que agregarle un evento click a cada boton de respuesta , no se como pasarle el id
    function contestarPregunta(respuestaId) {
        // hay que pasarle preguntaId tambien

        const url = '/juego/verificarRespuesta';
        const xhttp = new XMLHttpRequest();
        // Revisar como pasar los datos:
        const datosParaEnviar = {
            "respuestaId": respuestaId,
            "preguntaId": preguntaId
        };

        const postData = JSON.stringify(datosParaEnviar);
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                const respuestaJSON = this.responseText;

                try {

                    const data = JSON.parse(respuestaJSON);
                    console.log(data);
                    const ok = data.ok;

                    if (ok === true) {
                        if (data.verificacion === 'Respuesta correcta') {
                            // mensaje exito , siguiente pregunta
                            document.getElementById(`${data.respuestaIdCorrecta}`).classList.add('respuestaCorrectaAnimation');

                            respuestaCorrecta();

                        } else if (data.verificacion === 'Respuesta incorrecta') {
                            //terminar partida , mensaje de fracaso , boton volver al home
                            document.getElementById(`${data.respuestaIdCorrecta}`).classList.add('respuestaCorrectaAnimation');
                            document.getElementById(`${respuestaId}`).classList.add('respuestaIncorrecta');
                            puntaje = data.puntaje
                            respuestaIncorrecta();
                        }
                    }
                    if (ok === false) {
                        Swal.fire({
                            title: 'Error!',
                            text: data.error,
                            icon: 'error',
                            confirmButtonText: 'Volver'
                        })
                    }


                } catch (error) {
                    console.error("Error al parsear la respuesta JSON:", error);
                }

            }

        };

        xhttp.open("POST", url, true);
        xhttp.setRequestHeader("Content-Type", "application/json");

        xhttp.send(postData);


    }

function reintentarJuego() {
    window.location.reload();
}

function volverAlLobby() {
    window.location.href = '/lobby/lobby';
}

botonVolver.addEventListener('click', reintentarJuego);
botonInicio.addEventListener('click', volverAlLobby);


// Logica timer

let temporizador;
function timerVista(tiempo){
    const segundos = document.getElementById('segundos');

    let tiempoTimer = tiempo;

    temporizador = setInterval(() => {

        const seg = tiempo % 60;

        segundos.innerHTML = String(seg).padStart(2, '0');
        timer.classList.remove('oculto')


        tiempo --;

        if (tiempo < 0) {
            finalizarPartida();
        }

    }, 1000);

}

function finalizarPartida() {
    clearInterval(temporizador);
    for (let i = 0; i < botonesRespuestas.length; i++) {
        botonesRespuestas[i].disabled = true;
    }
    timer.classList.add('oculto');
    const url = '/juego/finalizarPartida';
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            const respuestaJSON = this.responseText;

            try {

                const data = JSON.parse(respuestaJSON);
                //console.log(data);
                const ok = data.ok;
                if (ok === true) {

                    puntaje = data.puntaje;

                    tiempoAcabado();


                }


            } catch (error) {
                console.error("Error al parsear la respuesta JSON:", error);
            }

        }

    };

    xhttp.open("GET", url, true);
    xhttp.send();
}


//Logica volver pregunta si actualizo

document.addEventListener('DOMContentLoaded', () => {
    const url = '/juego/devolverPregunta';
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            const respuestaJSON = this.responseText;

            try {

                const data = JSON.parse(respuestaJSON);
                console.log(data);
                const ok = data.ok;

                if (ok === true) {
                    vistaDeCarga();
                    cambiarAContenedorPregunta()
                    // fijarse como se recibe el json capaz es data.id y asi
                    const pregunta = data.pregunta;
                    preguntaId = pregunta.preguntaId;
                    const respuestas = data.respuestas;
                    const tiempo = data.tiempo;
                    console.log(data.time)
                    respuestas.forEach(respuesta => {
                        if (respuesta.esCorrecta) {
                            rtaCorrecta = respuesta;
                            idrespuestaCorrecta = respuesta.id_respuesta;
                        }
                    })
                    const descPregunta = document.getElementById("preguntas-descripcion");
                    descPregunta.textContent = pregunta.enunciado;
                    for (let i = 0; i < botonesRespuestas.length; i++) {
                        botonesRespuestas[i].id = respuestas[i].id_respuesta;
                        if (respuestas[i].esCorrecta) {
                            btnRtaCorrecta = botonesRespuestas[i].id;
                        }
                        botonesRespuestas[i].textContent = respuestas[i].respuestaTexto;
                        botonesRespuestas[i].onclick = () => {
                            //console.log(botonesRespuestas[i].id);
                            timer.classList.add('oculto');
                            clearInterval(temporizador);
                            contestarPregunta(botonesRespuestas[i].id);
                        };
                    }

                    timerVista(tiempo);
                }


            } catch (error) {
                console.error("Error al parsear la respuesta JSON:", error);
            }

        }

    };

    xhttp.open("GET", url, true);
    xhttp.send();
})

function vistaDeCarga() {

    Swal.fire({
        title: 'Cargando pregunta...',
        text: 'Por favor, espere un momento.',
        allowOutsideClick: false, // Evita que se cierre haciendo clic fuera
        showConfirmButton: false, // No muestra el botón 'Aceptar'
        timer: 1000,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

function enviarReporte(descripcion) {
    const url = '/juego/reportar';
    const xhttp = new XMLHttpRequest();

    const datosParaEnviar = {
        "preguntaId": preguntaId,
        "descripcion": descripcion,
    };
    const postData = JSON.stringify(datosParaEnviar);

    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            const respuestaJSON = this.responseText;

            try {

                const data = JSON.parse(respuestaJSON);
                console.log(data);
                const ok = data.ok;
                if (ok === true) {

                    Swal.fire({
                        title: '¡Reporte Enviado!',
                        text: 'Gracias por tu ayuda, revisaremos el error pronto.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });

                } else {

                    Swal.fire({
                        title: "¡Reporte no enviado!",
                        text: data.error,
                        icon: "error",
                        draggable: false,
                        timer: 1500,
                        showConfirmButton: false
                    });

                }


            } catch (error) {
                console.error("Error al parsear la respuesta JSON:", error);
            }

        }

    };

    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.send(postData);
}


function crearReporte(){
    Swal.fire({
        title: 'Reportar un Error',
        text: 'Por favor, describe el error que encontraste en esta pregunta.',

        // --- Configuración del textarea ---
        input: 'textarea', // Esto crea un área de texto para la entrada del usuario
        inputPlaceholder: 'Escribe tu descripción aquí...',
        inputAttributes: {
            'aria-label': 'Descripción del reporte',
            maxlength: 500 // Opcional: limitar la longitud
        },

        // --- Configuración de Botones ---
        showCancelButton: true, // Muestra el botón de Cancelar
        confirmButtonText: 'Enviar Reporte', // Texto para el botón de Enviar
        cancelButtonText: 'Cancelar', // Texto para el botón de Cancelar

        // --- Apariencia y Comportamiento ---
        icon: 'question', // Opcional: un icono para la alerta
        // draggable: false, // Ya lo tenías, pero puede eliminarse si no es necesario
        // timer: 1500, // Se elimina el timer para dar tiempo al usuario de escribir
        // showConfirmButton: false // Se elimina porque necesitamos los botones
    }).then((result) => {
        // --- Manejo de la Respuesta ---
        if (result.isConfirmed) {
            // El usuario presionó el botón de "Enviar Reporte" (Confirmar)
            const descripcion = result.value; // El texto escrito en el textarea
            if (descripcion && descripcion.trim() !== '') {
                // Llama a tu función para enviar el reporte con la descripción
                enviarReporte(descripcion);
            } else {
                // Manejar si el campo está vacío (opcional)
                Swal.fire('Atención', 'Debes escribir una descripción para enviar el reporte.', 'warning');
            }
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // El usuario presionó el botón de "Cancelar" o hizo clic fuera del modal
            // El modal se cierra automáticamente, no necesitas una acción adicional
            console.log("Reporte cancelado.");
        }
    });
}

