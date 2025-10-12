<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lobby</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Aside -->
            <div class="col-md-3 p-0">

                <div class="d-flex flex-column sidebar-container bg-dark p-3 min-vh-100">
                    <a href=""
                        class="d-none d-md-flex flex-column align-items-center mb-3 text-white text-decoration-none">
                        <img src="../img/logo.jpg" class="rounded-circle" style="max-width: 13%">
                        <span class="fs-4">Preguntados</span>
                    </a>
                    <hr class="d-none d-md-block text-white">

                    <div class="d-none d-md-flex align-items-center">
                        <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width: 15%; max-height: 15%">
                        <span class="ms-2 mt-1 fs-5 fw-bold">usuario1</span>
                    </div>
                    <hr class="d-none d-md-block text-white">

                    <ul
                        class="nav nav-pills flex-row flex-md-column justify-content-around justify-content-md-evenly align-items-start flex-grow-1">

                        <li class="nav-item">
                            <a href="" class="nav-link text-white d-flex align-items-center" aria-current="page">
                                <i class="bi bi-house-fill fs-4"></i>
                                <span class="d-none d-md-inline ms-2">Home</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-white d-flex align-items-center">
                                <i class="bi bi-joystick fs-4"></i>
                                <span class="d-none d-md-inline ms-2">Unirse a una partida</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-white d-flex align-items-center">
                                <i class="bi bi-twitter-x fs-4"></i>
                                <span class="d-none d-md-inline ms-2">Trivia X</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link text-white d-flex align-items-center">
                                <i class="bi bi-shop-window fs-4"></i>
                                <span class="d-none d-md-inline ms-2">Tienda</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="tienda.php" class="nav-link text-white d-flex align-items-center">
                                <i class="bi bi-globe fs-4"></i>
                                <span class="d-none d-md-inline ms-2">Idiomas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <div class="form-check form-switch">
                                <label class="form-check-label text-white d-none d-md-inline ms-2"
                                    for="switchCheckDefault">Modo
                                    Oscuro</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- Main lobby -->
            <section class="col-md-9 p-0 d-flex justify-content-center align-items-center" style="background-image: url(../img/texture-lobby.png); background-size: cover;">

                <article class="col-12 d-flex justify-content-center mt-3 align-items-center m-5 w-25 h-25 rounded-4" style="background-color: #FDF6E3; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.15), 
              0px 6px 20px rgba(0, 0, 0, 0.2);">
                    <div class="d-flex flex-column gap-4 justify-content-center">
                            <h2 style="font-family: 'Nunito Sans'; font-weight: 900; color: #3d3024;text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.35);">PREGUNTADOS</h2>
                            <button class="btn rounded-1 text-white" style="width: 250px; font-family: 'Nunito Sans'; font-weight: 900; background-color: #2A5A8C; border-color: #1A3858;">
                                PARTIDA SOLO
                            </button>
                            <button class="btn rounded-1 text-white" style="width: 250px; font-family: 'Nunito Sans'; font-weight: 900; background-color: #8E7DBE; border-color: #6B5C9C;">
                                PARTIDA MULTIJUGADOR
                            </button>
                        

                    </div>
                </article>

            </section>

        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>