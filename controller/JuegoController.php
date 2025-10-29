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

        $pregunta = $this->model->buscarPregunta($datos['categoria']);

    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}
