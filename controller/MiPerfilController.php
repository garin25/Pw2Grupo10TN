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
        $estadisticas = $this->model->obtenerEstadisticasDeJuego($usuarioId);
        $url_qr_publica = $usuario['img_qr'] ?? '';
        $data = ["page" => "Mi perfil", "logout" => "/login/logout", "usuario" => $usuario, "url_qr" => $url_qr_publica, "estadisticas" => $estadisticas];
        $this->renderer->render("miPerfil", $data);
    }

    public function editarPerfil() {
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }


    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }



}