<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <main>
        <section id="contenedor-login">
            <button id="volver" class="btn oculto">Volver</button>
            <div id="login-sup">
                <img id="login-img" src="..//img/logo.jpg" alt="">
                <h2 id="login-descripcion">Iniciar sesión</h2>
            </div>
            <div id="login-inf">
                
                <div id="contenedor-form">
                    <label id="label-email" class="label" for="email">Ingrese su email:</label>
                    <input id="email" class="email" placeholder="example@algo.com" name="email" type="text">
                </div>

                <button id="submit" class="btn">Verificar</button>

            </div>
        </section>
    </main>

    <script src="../js/login.js"></script>
</body>

</html>