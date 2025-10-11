<?php

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
<div class="d-flex flex-column sidebar-container p-3 min-vh-100" data-bs-theme="dark">
    <a href="" class="d-none d-md-flex flex-column align-items-center mb-3 text-white text-decoration-none">
        <img src="../img/logo.jpg" class="rounded-circle" style="max-width: 13%">
        <span class="fs-4">Preguntados</span>
    </a>
    <hr class="d-none d-md-block text-white">

    <div class="d-none d-md-flex align-items-center">
        <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width: 15%; max-height: 15%">
        <span class="ms-2 mt-1 fs-5 fw-bold text-white">usuario1</span>
    </div>
    <hr class="d-none d-md-block text-white">

    <ul class="nav nav-pills flex-row flex-md-column justify-content-around justify-content-md-evenly align-items-start flex-grow-1">

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
                <label class="form-check-label text-white d-none d-md-inline ms-2" for="switchCheckDefault">Modo
                    Oscuro</label>
                <input class="form-check-input" type="checkbox" role="switch" id="switchCheckDefault">
            </div>
        </li>
    </ul>
</div>

</body>

