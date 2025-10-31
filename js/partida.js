const ruleta = document.querySelector('.ruleta');
const btnGirar = document.getElementById('btn-girar');
const contenedorRuleta = document.getElementById('contenedor-ruleta');
const contenedorPreguntas = document.getElementById('contenedor-preguntas');
const botonesRespuestas = document.querySelectorAll('#preguntas-inf .btn');

let rtaCorrecta = null; // guardamos la rta correcta para no tener que ir devuelta hasta la bbdd
let btnRtaCorrecta = null; // id= a,b,c o d
let preguntaId = null;
let idrespuestaCorrecta;

contenedorRuleta.classList.add('visible');
contenedorPreguntas.classList.add('oculto');

const numSectores = 6;
const gradosPorSector = 360 / numSectores;
let anguloAcumulado = 0;



// funcion de giro de ruleta
function girarRuleta() {
    ruleta.classList.remove('girando');
    btnGirar.disabled = true;

    const sectorGanadorIndex = Math.floor(Math.random() * numSectores);
    const categoriaGanadora = getCategoria(sectorGanadorIndex+1);
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
            title: `¡Categoría ${sectorGanadorIndex + 1}!`,
            text: "¡Prepárate para responder la pregunta!",
            imageUrl: "../imagenes/logo.jpg",
            imageHeight: 100,
            confirmButtonText: "¡Vamos!",
            draggable: true
        }).then(() => {
            contenedorRuleta.classList.remove('visible');
            contenedorRuleta.classList.add('oculto');
            traerPregunta(categoriaGanadora);
            contenedorPreguntas.classList.remove('oculto');
            contenedorPreguntas.classList.add('visible');


        });

    }, 5000);
}
btnGirar.addEventListener('click', girarRuleta);

function getCategoria(sectorGanadorIndex) {
    switch (sectorGanadorIndex){
        case 1:
            return 'Deporte'
        break;
        case 2:
            return 'Historia'
            break;
        case 3:
            return 'Ciencias Naturales'
            break;
        case 4:
            return 'Geografía'
            break;
        case 5:
            return 'Programación'
            break;
        case 6:
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
        cambiarAContenedorRuleta();
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
                        const respuestas = data.pregunta.respuestas;

                        respuestas.forEach(respuesta => {
                            if (respuesta.esCorrecta) {
                                rtaCorrecta = respuesta;
                                idrespuestaCorrecta = respuesta.respuestaId;
                            }
                        })
                        const descPregunta = document.getElementById("preguntas-descripcion");
                        descPregunta.textContent = pregunta.descripcion;
                        for (let i = 0; i < botonesRespuestas.length; i++) {
                            if (respuestas[i].esCorrecta) {
                                btnRtaCorrecta = botonesRespuestas[i].id;
                            }
                            botonesRespuestas[i].textContent = respuestas[i].respuestaTexto;
                            botonesRespuestas[i].onclick = () => {
                                contestarPregunta(botonesRespuestas[i].textContent);
                            };
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

// Hay que agregarle un evento click a cada boton de respuesta , no se como pasarle el id
    function contestarPregunta(respuestaTexto) {
        // hay que pasarle preguntaId tambien

        const url = '/juego/verificarRespuesta';
        const xhttp = new XMLHttpRequest();
        // Revisar como pasar los datos:
        const datosParaEnviar = {
            "respuestaTexto": respuestaTexto,
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