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

        $usuario = $this->model->buscarDatosUsuario($_SESSION["usuarioId"]);

        $data = ["page" => "Mi perfil", "usuario" => $usuario];
        $this->renderer->render("miPerfil", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }



}