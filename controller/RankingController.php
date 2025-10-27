<?php

class RankingController
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
        $this->ranking();
    }

    public function ranking()
    {
        $usuarioId = $_SESSION['usuarioId'];

        if (!isset($usuarioId)) {
            $this->redirectToIndex();
        }

        $usuario = $this->model->buscarDatosUsuario($_SESSION["usuarioId"]);
        $data = ["page" => "Ranking", "usuario" => $usuario];
        $this->renderer->render("ranking", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}