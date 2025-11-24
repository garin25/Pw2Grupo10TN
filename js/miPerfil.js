const cerrar = document.getElementById("cerrar");
const modal = document.getElementById("modal");
const nombreUsuario = document.getElementById("nombreUsuario");
const fotoPerfil = document.getElementById("foto-perfil");
const imagenBlob = document.getElementById("imagen-blob");
let objectURL = '';
const nombreOriginal = document.getElementById("nombre-original");
const imgOriginal = document.getElementById("img-original");


cerrar.addEventListener("click", (e) => {
    modal.classList.add("oculto");
    URL.revokeObjectURL(objectURL)
    nombreUsuario.value = nombreOriginal.innerHTML;
    imagenBlob.src = imgOriginal.src;
})

modal.addEventListener("click", (e) => {
    if(e.target == modal) {
        modal.classList.add("oculto");
        URL.revokeObjectURL(objectURL)
        nombreUsuario.value = nombreOriginal.innerHTML;
        imagenBlob.src = imgOriginal.src;
    }
})

function abrirModal() {
    modal.classList.remove("oculto");
}

function editarPerfil(){

    if(nombreUsuario.value != nombreOriginal.innerHTML || imagenBlob.src != imgOriginal.src){

        const formData = new FormData();
        formData.append("fotoPerfil", fotoPerfil.files[0], fotoPerfil.files[0].name);
        formData.append("nombreUsuario", nombreUsuario.value);

        postData('/miPerfil/editarPerfil',
            formData)
            .then(data => {
                console.log(data);

                if (data.ok){
                    enviadoCorrectamente(data.msj)
                    vaciarForm(data.urlFoto);
                }

                if (data.error == "form"){
                    completarTodosLosDatos(data.msj);
                }

                if (data.error == "error"){
                    noSeHaEnviado(data.msj)
                }

            });

    } else  {
        modal.classList.add("oculto");
        URL.revokeObjectURL(objectURL)
        nombreUsuario.value = nombreOriginal.innerHTML;
        imagenBlob.src = imgOriginal.src;
    }



}

function vaciarForm(urlFoto){
    if (urlFoto){
        imgOriginal.src = `/${urlFoto}`;
    }
    modal.classList.add("oculto");
    URL.revokeObjectURL(objectURL)
    nombreOriginal.innerHTML = nombreUsuario.value;

}



async function postData(url = '', data = {}) {

    const response = await fetch(url, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: data
    });
    return response.json();
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

fotoPerfil.addEventListener('change', function(event) {
    const input = event.target;

    if (input.files && input.files.length > 0) {

        URL.revokeObjectURL(objectURL)

        const imageFile = input.files[0];

        objectURL = URL.createObjectURL(imageFile);

        imagenBlob.src = objectURL;


    }
});