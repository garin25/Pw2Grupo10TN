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
        $this->loginForm();
    }

    public function loginForm()
    {
        $data = ["page" => "Mi perfil"];
        $this->renderer->render("miPerfil", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}