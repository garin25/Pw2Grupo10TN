<?php

class PerfilController
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
        $this->user();
    }

    public function user()
    {
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuarioNombre = $_GET['usuario'];
        $usuario = $this->model->buscarDatosUsuarioPorId($usuarioId);
        $usuarioConsultado = $this->model->buscarDatosUsuario($usuarioNombre);

        if($usuarioConsultado != null){
            $data = ["page" => "Perfil de " . $usuarioNombre,  "logout" => "/login/logout", "usuario" => $usuario, "usuarioConsultado" => $usuarioConsultado];
            $this->renderer->render("perfil", $data);
        } else {
            $this->redirectToIndex();
        }



    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }



}