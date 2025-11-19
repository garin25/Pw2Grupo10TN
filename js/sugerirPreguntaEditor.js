const cerrar = document.getElementById("cerrar");
const modal = document.getElementById("modal");
const enunciado = document.getElementById("enunciado");
const categoria = document.getElementById("categoria");


cerrar.addEventListener("click", (e) => {
    modal.classList.add("oculto");
})

modal.addEventListener("click", (e) => {
    if(e.target == modal) {
        modal.classList.add("oculto");
    }
})

function verCompleta(preguntaId){
    let url =  `/editor/traerPreguntaSugerida?preguntaId=${preguntaId}`;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            console.log(data)

            if(data.ok){

                enunciado.innerHTML = data.pregunta['enunciado'];

                categoria.innerHTML = data.categoria['nombre'];

                let i = 1;
                data.respuestas.forEach(respuesta => {

                    document.getElementById(`respuesta${i}`).innerHTML = respuesta['respuestaTexto'];
                    if(respuesta['esCorrecta'] === 1){
                        document.getElementById(`rta${i}`).checked = true;
                    }
                    i++;
                })

                modal.classList.remove("oculto");


            } else {
                error(data.mensaje)
            }

        })

}

function denegarPregunta(preguntaId){
    let url =  `/editor/denegarPreguntaSugerida?preguntaId=${preguntaId}`;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            console.log(data)
            if (data.ok) {
                ok(data.mensaje)
            } else {
                error(data.mensaje)
            }
            remover(preguntaId);
        })

}

function permitirPregunta(preguntaId){
    let url =  `/editor/permitirPreguntaSugerida?preguntaId=${preguntaId}`;
    fetch(url)
        .then(res => res.json())
        .then(data => {
            console.log(data)
            if (data.ok) {
                ok(data.mensaje);
            } else {
                error(data.mensaje);
            }
            remover(preguntaId);
        })

}

function remover(preguntaId){

    document.getElementById(preguntaId).remove();

}

function ok(msj) {
    Swal.fire({
        title: msj,
        icon: "success",
        draggable: false,
        timer: 1000,
        showConfirmButton: false
    });
}

function error(error) {
    Swal.fire({
        title: error,
        icon: "error",
        draggable: false,
        timer: 1000,
        showConfirmButton: false
    });
}

