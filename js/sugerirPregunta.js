
const categoria = document.getElementById("categoria");
const enunciado = document.getElementById("enunciado");
const respuestas = document.getElementsByName("respuestas");
const rtaCorrecta = document.getElementsByName("rtaCorrecta");
const submit = document.getElementById("submit");

let url = "/editor/buscarCategorias"

document.addEventListener("DOMContentLoaded", () => {
    fetch(url)
        .then(res => res.json())
        .then(data => {
            console.log(data)
            data.categorias.forEach(c => {
                categoria.innerHTML += `<option value="${c.categoriaId}">${c.nombre}</option>`
            })

        })
})


submit.addEventListener("click", e => {
    let respuestasEnviar= [];
    let rtaEnviar = "";

    respuestas.values().forEach(respuesta => {
        respuestasEnviar.push(respuesta.value);
    })

    rtaCorrecta.forEach(rta => {
        if (rta.checked) {
            rtaEnviar = rta.value;
        }
    })
    console.log(respuestasEnviar);
    console.log(categoria.value);
    console.log(enunciado.value);
    console.log(rtaEnviar);

    postData('/juego/enviarPreguntaSugerida',
        {
        respuestas: respuestasEnviar,
        categoria: categoria.value,
        enunciado: enunciado.value,
        respuestaCorrecta: rtaEnviar
        })
        .then(data => {
            console.log(data);

            if (data.ok){
                enviadoCorrectamente(data.msj)
                vaciarForm();
            }

            if (data.error == "form"){
                completarTodosLosDatos(data.msj);
            }

            if (data.error == "error"){
                noSeHaEnviado(data.msj)
            }

        });
})

function vaciarForm(){
    categoria.value = 1;
    enunciado.value = "";
    respuestas.forEach(respuesta => {
        respuesta.value = "";
    })
    rtaCorrecta.forEach(rta => {
        rta.checked = false;
    })
}


// Ejemplo implementando el metodo POST:
async function postData(url = '', data = {}) {
    // Opciones por defecto estan marcadas con un *
    const response = await fetch(url, {
        method: 'POST', // *GET, POST, PUT, DELETE, etc.
        mode: 'cors', // no-cors, *cors, same-origin
        cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
        credentials: 'same-origin', // include, *same-origin, omit
        headers: {
            'Content-Type': 'application/json'
            // 'Content-Type': 'application/x-www-form-urlencoded',
        },
        redirect: 'follow', // manual, *follow, error
        referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data) // body data type must match "Content-Type" header
    });
    return response.json(); // parses JSON response into native JavaScript objects
}

function enviadoCorrectamente(msj) {
    Swal.fire({
        title: msj,
        icon: "success",
        draggable: false,
        timer: 2000,
        showConfirmButton: false
    });
}

function noSeHaEnviado(msj) {
    Swal.fire({
        title: msj,
        icon: "error",
        draggable: false,
        timer: 2000,
        showConfirmButton: false
    });
}

function completarTodosLosDatos(msj) {
    Swal.fire({
        title: "Complete el formulario",
        text: msj,
        icon: "info",
        draggable: false,
        timer: 2000,
        showConfirmButton: false
    });
}
