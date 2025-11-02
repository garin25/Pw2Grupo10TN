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
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $ranking = $this->model->buscarRanking();

        $data = ["page" => "Ranking",  "logout" => "/login/logout", "usuario" => $usuario, "ranking" => $ranking];
        $this->renderer->render("ranking", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}