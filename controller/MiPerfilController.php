<?php

class MiPerfilController
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
        $this->miPerfil();
    }

    public function miPerfil()
    {
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION["usuarioId"];


        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $data = ["page" => "Mi perfil",  "logout" => "/login/logout", "usuario" => $usuario];
        $this->renderer->render("miPerfil", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }



}