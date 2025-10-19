
const volver = document.getElementById("volver");

function addClickSubmit() {
    const submit = document.getElementById("submit");
    submit.addEventListener("click", () => {
        const url = '/login/verificarEmail';
        const xhttp = new XMLHttpRequest();
        const datosParaEnviar = {
            email: document.getElementById("email").value
        };

        const postData = JSON.stringify(datosParaEnviar);
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                const respuestaJSON = this.responseText;

                try {

                    const data = JSON.parse(respuestaJSON);
                    console.log(data);
                    const ok = data.ok;

                    if (ok == true) {
                        // 1. Accede a las variables directamente desde 'data' (no data.usuario)
                        const usuarioId = data.usuarioId;

                        // 2. Lee el campo que PHP realmente envía: 'nombre_usuario'
                        const user = data.nombre_usuario;

                        cargarPassword(usuarioId, user);
                    }
                    if (ok == false) {
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
    })
}

addClickSubmit();

function cargarPassword(usuarioId, user) {
    const contenedorInf = document.getElementById("login-inf");
    const loginDescripcion = document.getElementById("login-descripcion");
    volver.classList.toggle("oculto")
    loginDescripcion.innerText = "Bienvenido " + user;
    contenedorInf.innerHTML = "";
    contenedorInf.innerHTML = `<div id="contenedor-form">
                    <label id="label-pass" class="label" for="pass">Ingrese su contraseña:</label>
                    <input id="pass" class="email" name="pass" type="password">
                </div>

                <button id="submit-form" class="btn">Iniciar sesión</button> `

    addClickSubmitForm(usuarioId);
    
}

function addClickSubmitForm(usuarioId) {
    const submitForm = document.getElementById("submit-form");
    submitForm.addEventListener("click", () => {
        const url = '/login/verificarPass';
        const xhttp = new XMLHttpRequest();
        const datosParaEnviar = {
            usuarioId: usuarioId,
            pass: document.getElementById("pass").value
        };

        const postData = JSON.stringify(datosParaEnviar);
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {

                const respuestaJSON = this.responseText;

                try {

                    const data = JSON.parse(respuestaJSON);
                    const ok = data.ok;
                    console.log(data);
                    if (ok == true) {
                        window.location.href = "/lobby";
                    }
                    if (ok == false) {
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
    })
}

function cargarEmail() {
    const contenedorInf = document.getElementById("login-inf");
    volver.classList.toggle("oculto")
    contenedorInf.innerHTML = "";
    contenedorInf.innerHTML = `<div id="contenedor-form">
                    <label id="label-email" class="label" for="email">Ingrese su email:</label>
                    <input id="email" class="email" placeholder="example@algo.com" name="email" type="text">
                </div>

                <button id="submit" class="btn">Verificar</button>`;
}

volver.addEventListener("click", () => {
        cargarEmail()
        addClickSubmit()
    })
