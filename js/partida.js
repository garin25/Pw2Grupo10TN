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


const numSectores = 6;
const gradosPorSector = 360 / numSectores;
let anguloAcumulado = 0;



// funcion de giro de ruleta
function girarRuleta() {
    ruleta.classList.remove('girando');
    btnGirar.disabled = true;

    const sectorGanadorIndex = Math.floor(Math.random() * numSectores);
    const categoriaGanadora = getCategoria(sectorGanadorIndex);
    const anguloObjetivo = sectorGanadorIndex * gradosPorSector + gradosPorSector / 2;
    const girosCompletos = 5;
    const anguloTotalDeGiro = (girosCompletos * 360) + anguloObjetivo;

    anguloAcumulado += anguloTotalDeGiro;

    ruleta.style.transform = `rotate(-${anguloAcumulado}deg)`;
    ruleta.classList.add('girando');

    //categoriaa
    setTimeout(() => {
        btnGirar.disabled = false;

        Swal.fire({
            title: `¡Categoría ${categoriaGanadora}!`,
            text: "¡Prepárate para responder la pregunta!",
            imageUrl: "../imagenes/logo.jpg",
            imageHeight: 100,
            confirmButtonText: "¡Vamos!",
            draggable: true
        }).then(() => {
            cambiarAContenedorPregunta()
            traerPregunta(categoriaGanadora);
        });

    }, 5000);
}
btnGirar.addEventListener('click', girarRuleta);

function getCategoria(sectorGanadorIndex) {
    switch (sectorGanadorIndex){
        case 0:
            return 'Deporte'
        break;
        case 1:
            return 'Historia'
            break;
        case 2:
            return 'Ciencias Naturales'
            break;
        case 3:
            return 'Geografía'
            break;
        case 4:
            return 'Programación'
            break;
        case 5:
            return 'Matemática'
            break;
    }
}
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
    contenedorPreguntas.classList.remove('visible');
    contenedorPreguntas.classList.add('oculto');
    contenedorPerder.querySelector("#puntaje").textContent += puntaje;
    contenedorPerder.classList.remove('oculto');
    contenedorPerder.classList.add('visible');
}


function respuestaCorrecta() {
    Swal.fire({
        title: "¡Respuesta correcta!",
        text: "¡Sigue así!",
        icon: "success",
        draggable: true,
        timer: 2000,
        showConfirmButton: false
    }).then(() => {
        cambiarAContenedorRuleta();
    });
}

function respuestaIncorrecta(){
    Swal.fire({
        title: "Respuesta incorrecta",
        text: "¡Game over!",
        icon: "error",
        draggable: true,
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        // crear estadisticas partida y boton volver al home
        cambiarAPartidaPerdida()
    });
}

function tiempoAcabado(){
    Swal.fire({
        title: "Tiempo acabado",
        text: "¡Game over!",
        icon: "error",
        draggable: true,
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
                            respuestaCorrecta();
                        } else {
                            //terminar partida , mensaje de fracaso , boton volver al home
                            if(data.puntaje){
                                puntaje = data.puntaje
                            }
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
    timer.classList.add('oculto');
    const url = '/juego/finalizarPartida';
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {

            const respuestaJSON = this.responseText;

            try {

                const data = JSON.parse(respuestaJSON);
                console.log(data);
                const ok = data.ok;

                if (ok === true) {
                    if(data.puntaje){
                        puntaje = data.puntaje
                    }
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

