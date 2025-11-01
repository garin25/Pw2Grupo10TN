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

    public function juego()
    {
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION["usuarioId"];

        if (!isset($_SESSION['puntosPartida'])) {
            $_SESSION['puntosPartida'] = 0;
        }

        unset($_SESSION['preguntaId']);
        unset($_SESSION['respuestaTexto']);

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $data = ["page" => "Preguntas",  "logout" => "/login/logout", "usuario" => $usuario];
        $this->renderer->render("juego", $data);
    }

    public function pregunta(){

        if (!isset($_SESSION['usuarioId'])){
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

        if(isset($_SESSION['preguntaId'])){
           // $pregunta = $this->model->buscarPregunta($datos['categoria'], $datos['dificultad'], $_SESSION['preguntaId']);
            $pregunta = $this->model->buscarPregunta($datos['categoria'], "Dificil", $_SESSION['preguntaId']);
        } else {
            //$pregunta = $this->model->buscarPregunta($datos['categoria'], $datos['dificultad'], null);
            $pregunta = $this->model->buscarPregunta($datos['categoria'],"Dificil", null);
        }

        if(!$pregunta){
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
        $respuesta = ['ok' => true, 'pregunta' => $pregunta,'respuestas' => $respuestas];
        echo json_encode($respuesta);


    }

    public function verificarRespuesta(){

        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if(!isset($datos['preguntaId']) || $datos['preguntaId'] == ""){
            $respuesta = ['ok' => false, 'error' => 'Datos no enviados'];
            echo json_encode($respuesta);
            return;
        }

        if(!isset($_SESSION['preguntaId'])){
            $respuesta = ['ok' => false, 'error' => 'Pregunta no encontrada'];
            echo json_encode($respuesta);
            return;
        }

        $usuarioId = $_SESSION['usuarioId'];
        $preguntaId = $_SESSION['preguntaId'];
        $idRespuesta = $_SESSION['id_respuesta'];
        $puntosPartida = $_SESSION['puntosPartida'];

        if ($preguntaId !== $datos['preguntaId']) {
            $respuesta = ['ok' => false, 'error' => 'Pregunta no coincide'];
            $this->model->partidaFinalizada($puntosPartida, $usuarioId);
        } else if($idRespuesta == $datos['respuestaId']) {
            $respuesta = ['ok' => true, 'verificacion' => 'Respuesta correcta'];
            $_SESSION['puntosPartida'] += 10;
        } else {
            //$respuesta = ['ok' => true, 'verificacion' => 'Respuesta incorrecta'];
            $respuesta = ['ok' => true, 'verificacion' => 'Respuesta incorrecta','puntaje' => $_SESSION['puntosPartida']];
            $_SESSION['puntosPartida'] = 0;//Limpio por si vuelve a jugar
            $this->model->partidaFinalizada($puntosPartida, $usuarioId);
        }

        echo json_encode($respuesta);

    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}
