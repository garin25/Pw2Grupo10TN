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
        $usuarioId = $_SESSION["usuarioId"];

        if (!isset($usuarioId)) {
            $this->redirectToIndex();
        }

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $data = ["page" => "Preguntas", "usuario" => $usuario];
        $this->renderer->render("juego", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}
