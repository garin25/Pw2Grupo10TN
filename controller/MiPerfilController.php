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
        $usuarioId = $_SESSION["usuarioId"];

        if (!isset($usuarioId)) {
            $this->redirectToIndex();
        }

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $data = ["page" => "Mi perfil", "usuario" => $usuario];
        $this->renderer->render("miperfil", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }



}