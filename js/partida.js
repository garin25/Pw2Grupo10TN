const ruleta = document.querySelector('.ruleta');
const btnGirar = document.getElementById('btn-girar');
const contenedorRuleta = document.getElementById('contenedor-ruleta');
const contenedorPreguntas = document.getElementById('contenedor-preguntas');
const botonesRespuestas = document.querySelectorAll('#preguntas-inf .btn');

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
            contenedorPreguntas.classList.remove('oculto');
            contenedorPreguntas.classList.add('visible');
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

botonesRespuestas.forEach(boton => {
    boton.addEventListener('click', () => {
        if (boton.id === 'b') {
            respuestaCorrecta();
        } else {
            Swal.fire({
                title: "Respuesta incorrecta",
                text: "¡Inténtalo de nuevo!",
                icon: "error",
                draggable: true,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                cambiarAContenedorRuleta();
            });
        }
    });
});
