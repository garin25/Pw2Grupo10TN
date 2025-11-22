<?php

class JuegoController
{
    private $model;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->model = $model;
        $this->renderer = $renderer;
    }

    public function base()
    {
        $this->juego();
    }

    public function juego(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION["usuarioId"];

        if (!isset($_SESSION['puntosPartida'])) {
            $_SESSION['puntosPartida'] = 0;
        }
        if(!isset($_SESSION['preguntasVistas'])) {
            $_SESSION['preguntasVistas'] = [];
        }
        if(!isset($_SESSION['reportesHechos'])) {
            $_SESSION['reportesHechos'] = 0;
        }

        $categorias = $this->model->traerCategoriasActivas();

        $categoriasProcesadas = [];
        $totalCategorias = count($categorias);

        $gradientCSS = "";

        if ($totalCategorias > 0) {
            $porcentajePorSector = 100 / $totalCategorias;

            for ($i = 0; $i < $totalCategorias; $i++) {
                $categoria = $categorias[$i];
                $color = $categoria['color'];

                $gradosPorSector = 360 / $totalCategorias;
                $categoria['grados'] = ($i * $gradosPorSector) + ($gradosPorSector / 2);

                $inicioPorcentaje = $i * $porcentajePorSector;
                $finPorcentaje = ($i + 1) * $porcentajePorSector;

                $gradientCSS .= "$color $inicioPorcentaje% $finPorcentaje%, ";

                $categoriasProcesadas[] = $categoria;
            }
            $gradientCSS = rtrim($gradientCSS, ", ");
        }


        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $data = ["page" => "Preguntas",
            "logout" => "/login/logout",
            "usuario" => $usuario,
            "categorias" => $categoriasProcesadas,
            "gradientCSS" => $gradientCSS // <-- ¡Pasamos el nuevo string de CSS!
        ];

        $this->renderer->render("juego", $data);
    }

    public function pregunta(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if(!isset($datos['categoria']) || $datos['categoria'] == ""){
            $respuesta = ['ok' => false, 'error' => 'Categoria no encontrada'];
            echo json_encode($respuesta);
            return;
        }

        $ids_a_evitar = $this->model->traerIdsAEvitar($_SESSION['usuarioId']);

        // Recuperamos el array de IDs a evitar
        //$ids_a_evitar = isset($_SESSION['preguntasVistas']) ? $_SESSION['preguntasVistas'] : [];
        $pregunta = $this->model->buscarPregunta($datos['categoria'],  $_SESSION['dificultad'], $ids_a_evitar, $_SESSION['usuarioId']);

// Añadimos el ID nuevo al array de la sesión
        if ($pregunta != null) {
            // Añadimos el nuevo ID a la lista
            //$_SESSION['preguntasVistas'][] = $pregunta['preguntaId'];
            $this->model->agregarIdsAEvitar($_SESSION['usuarioId'], $pregunta['preguntaId']);
        } else {
            $respuesta = ['ok' => false, 'error' => 'No se encontraron más preguntas para esta categoría.'];
            echo json_encode($respuesta);
            return;
        }

        $respuestas = $this->model->buscarRespuestas($pregunta["preguntaId"]);


        for($i = 0; $i < count($respuestas); $i++){
            if($respuestas[$i]["esCorrecta"]===1){
                $_SESSION['id_respuesta'] = $respuestas[$i]["id_respuesta"];
            }
        }
        $_SESSION['preguntaId'] = $pregunta['preguntaId'];

        if(!isset($_SESSION['tiempo']) || $_SESSION['tiempo'] == 0){
            $tiempo = 15;
            $_SESSION['tiempo'] = time();
        }

        $this->model->aumentarCantidadEnviadaEnPregunta($pregunta["preguntaId"]);

        $respuesta = ['ok' => true, 'pregunta' => $pregunta,'respuestas' => $respuestas, 'tiempo' => $tiempo];
        echo json_encode($respuesta);


    }

    public function verificarRespuesta(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if(!isset($datos['preguntaId']) || $datos['preguntaId'] == ""){
            $respuesta = ['ok' => false, 'error' => 'Datos no enviados'];
            $this->resetSesion();
            echo json_encode($respuesta);
            return;
        }

        if(!isset($_SESSION['preguntaId'])){
            $respuesta = ['ok' => false, 'error' => 'Pregunta no encontrada'];
            $this->resetSesion();
            echo json_encode($respuesta);
            return;
        }

        $usuarioId = $_SESSION['usuarioId'];
        $preguntaId = $_SESSION['preguntaId'];
        $idRespuesta = $_SESSION['id_respuesta'];
        $puntosPartida = $_SESSION['puntosPartida'];

        if(isset($_SESSION['tiempo']) && (time() - $_SESSION['tiempo']) > 15){
            $respuesta = ['ok' => false, 'error' => 'Se acabo el tiempo','puntaje' => $_SESSION['puntosPartida']];
            $this->model->partidaFinalizada($puntosPartida, $usuarioId);
            $this->resetSesion();
            echo json_encode($respuesta);
            return;
        }

        if ($preguntaId !== $datos['preguntaId']) {
            $respuesta = ['ok' => false, 'error' => 'Pregunta no coincide'];
            $this->model->partidaFinalizada($puntosPartida, $usuarioId);
            $this->resetSesion();
        } else if($idRespuesta == $datos['respuestaId']) {
            $respuesta = ['ok' => true, 'verificacion' => 'Respuesta correcta', 'respuestaIdCorrecta' => $_SESSION['id_respuesta']];
            $_SESSION['puntosPartida'] += 10;
            $_SESSION['tiempo'] = 0;
            $this->model->agregarRespuestaAlHistorial($_SESSION["preguntaId"], $_SESSION['usuarioId'], true, date("Y-m-d H:i:s", time()));
            unset($_SESSION['preguntaId']);
            unset($_SESSION['id_respuesta']);
        } else {
            $respuesta = ['ok' => true, 'verificacion' => 'Respuesta incorrecta','puntaje' => $_SESSION['puntosPartida'], 'respuestaIdCorrecta' => $_SESSION['id_respuesta']];
            //$_SESSION['preguntasVistas'] = [];
            $this->model->aumentarRespondidasMalEnPregunta($_SESSION["preguntaId"]);
            $this->model->agregarRespuestaAlHistorial($_SESSION["preguntaId"], $_SESSION['usuarioId'], false, date("Y-m-d H:i:s", time()));
            $this->model->partidaFinalizada($puntosPartida, $usuarioId);
            $this->resetSesion();
        }
        echo json_encode($respuesta);

    }

    public function finalizarPartida(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        $respuesta = ['ok' => true, 'verificacion' => 'Tiempo acabado', 'puntaje' => $_SESSION['puntosPartida'], 'respuestaIdCorrecta' => $_SESSION['id_respuesta']];
        $this->model->aumentarRespondidasMalEnPregunta($_SESSION["preguntaId"]);
        $this->model->agregarRespuestaAlHistorial($_SESSION["preguntaId"], $_SESSION['usuarioId'], false, date("Y-m-d H:i:s", time()));
        $this->model->partidaFinalizada($_SESSION['puntosPartida'], $_SESSION['usuarioId']);
        $this->resetSesion();
        echo json_encode($respuesta);
    }

    public function resetSesion(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        unset($_SESSION['preguntaId']);
        unset($_SESSION['id_respuesta']);
        unset($_SESSION['reportesHechos']);
        //unset($_SESSION['preguntasVistas']);
        unset($_SESSION['puntosPartida']);
        unset($_SESSION['tiempo']);
    }

    public function devolverPregunta(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        if(isset($_SESSION['puntosPartida']) && isset($_SESSION['preguntaId'])
            && isset($_SESSION['id_respuesta']) && isset($_SESSION['tiempo'])) {

            $pregunta = $this->model->devolverPregunta($_SESSION['preguntaId']);
            $respuestas = $this->model->buscarRespuestas($_SESSION['preguntaId']);

            if((time() - $_SESSION['tiempo']) > 15){
                $tiempo = 0;
            } else {
                $tiempo = 15 - (time() - $_SESSION['tiempo']);
            }

            $respuesta = ['ok' => true, 'pregunta' => $pregunta,'respuestas' => $respuestas, 'tiempo' => $tiempo];


        } else {
            $respuesta = ['ok' => false];
        }

        echo json_encode($respuesta);
    }

    public function reportar(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if ($datos['preguntaId'] != "" && $datos['descripcion'] != "" && $_SESSION['reportesHechos'] <= 3) {

            $this->model->reportarPregunta($datos['preguntaId'], $_SESSION['usuarioId'], $datos['descripcion']);
            $cantidadReportes = $this->model->verCantidadDeReportesPorPregunta($datos['preguntaId']);

            if($cantidadReportes['cantidadReportes'] > 5){
                $this->model->editarEstadoDeReporte($datos['preguntaId']);
            }

            $_SESSION['reportesHechos'] += 1;
            $respuesta = ['ok' => true, 'cantidadReportes' => $cantidadReportes];


        } else {
            $respuesta = ['ok' => false, 'error' => 'Has hecho demasiados reportes en esta partida'];
        }

        echo json_encode($respuesta);

    }

    public function sugerirPregunta(){

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        $usuarioId = $_SESSION["usuarioId"];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $data = ["page" => "Sugerir Pregunta",  "logout" => "/login/logout", "usuario" => $usuario];
        $this->renderer->render("sugerirPregunta", $data);

    }

    public function enviarPreguntaSugerida()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 1) {
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if ($datos['enunciado'] == "") {
            $respuesta = ['ok' => false, 'error' => "form", 'msj' => "Por favor escriba un enunciado"];
            echo json_encode($respuesta);
            return;
        }

        foreach ($datos['respuestas'] as $respuesta) {
            if($respuesta == ""){
                $respuesta = ['ok' => false, 'error' => "form", 'msj' => "Por favor escriba las respuestas"];
                echo json_encode($respuesta);
                return;
            }
        }

        if ($datos['respuestaCorrecta'] == "") {
            $respuesta = ['ok' => false, 'error' => "form", 'msj' => "Por favor seleccione una respuesta como correcta"];
            echo json_encode($respuesta);
            return;
        }

        if ($datos['categoria'] == "") {
            $respuesta = ['ok' => false, 'error' => "form", 'msj' => "Por favor seleccione categoria"];
        }

        $result = $this->model->enviarPreguntaSugerida($datos['enunciado'], $datos['respuestas'], $datos['categoria'], $datos['respuestaCorrecta']);

        if($result){
            $respuesta = ['ok' => true, 'msj' => "Pregunta enviada correctamente"];
        } else {
            $respuesta = ['ok' => false, 'error' => "error", 'msj' => "No se pudo enviar la pregunta"];
        }

        echo json_encode($respuesta);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}
