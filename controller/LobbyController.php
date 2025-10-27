<?php
class LobbyController
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
        $this->lobby();
    }

    public function lobby()
    {
        $usuarioId = $_SESSION["usuarioId"];

        if(!isset($usuarioId)){
            $this->redirectToIndex();
        }
        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $data = ["page" => "Lobby",  "logout" => "/login/logout", "usuario" => $usuario];
        $this->renderer->render("lobby", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}