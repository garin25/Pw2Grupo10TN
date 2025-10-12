
const volver = document.getElementById("volver");


function addClickSubmit() {
    const submit = document.getElementById("submit");
    submit.addEventListener("click", () => {
        
        cargarPassword();

    })
}

addClickSubmit();

function cargarPassword() {
    const contenedorInf = document.getElementById("login-inf");
    volver.classList.toggle("oculto")
    contenedorInf.innerHTML = "";
    contenedorInf.innerHTML = `<div id="contenedor-form">
                    <label id="label-pass" class="label" for="pass">Ingrese su contraseña:</label>
                    <input id="pass" class="email" name="pass" type="password">
                </div>

                <button id="submit-form" class="btn">Iniciar sesión</button> `
    
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
