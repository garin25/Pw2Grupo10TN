
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>
<body>
<div class="container-fluid">
    <div class="row">

        <div class="col-md-3 p-0 bg-dark">
            <?php require_once 'partial/sidebar.php'; ?>
        </div>

        <div class="col-md-9" data-bs-theme="light">
            <main>
                <div class="d-flex justify-content-between align-items-center">

                    <h3 class="mb-0">Ranking</h3>

                    <div class="form-check form-switch form-check-reverse">
                        <input class="form-check-input" type="checkbox" id="switchCheckReverse">
                        <label class="form-check-label" for="switchCheckReverse">Solo Amigos</label>
                    </div>

                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th scope="col">Posicion</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Puntos</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="table-success">
                            <th scope="row">1</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Juan
                            </td>
                            <td>10</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Ana
                            </td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Luis
                            </td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                María
                            </td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <th scope="row">5</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Carlos
                            </td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <th scope="row">6</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Sofía
                            </td>
                            <td>60</td>
                        </tr>
                        <tr>
                            <th scope="row">7</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Pedro
                            </td>
                            <td>70</td>
                        </tr>
                        <tr>
                            <th scope="row">8</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Lucía
                            </td>
                            <td>80</td>
                        </tr>
                        <tr>
                            <th scope="row">9</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Javier
                            </td>
                            <td>90</td>
                        </tr>
                        <tr>
                            <th scope="row">10</th>
                            <td>
                                <img src="../img/fotoPerfil.jpg" class="rounded-circle" style="max-width:5%;">
                                Lautaro
                            </td>
                            <td>100</td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </main>
        </div>

    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>