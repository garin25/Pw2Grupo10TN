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

        $usuarioLogueadoId = $_SESSION['usuarioId'];

        $usuarioNombre = $_GET['usuario'];

        $usuario = $this->model->buscarDatosUsuarioPorId($usuarioLogueadoId);

        $usuarioConsultado = $this->model->buscarDatosUsuario($usuarioNombre);

        if($usuarioConsultado != null){

            $usuarioConsultadoId = $usuarioConsultado['usuarioId'];

            $estadisticas = $this->model->obtenerEstadisticasDeJuego($usuarioConsultadoId);

            $url_qr_publica = $usuarioConsultado['img_qr'] ?? '';

            $data = ["page" => "Perfil de " . $usuarioNombre, "logout" => "/login/logout", "usuario" => $usuario, "usuarioConsultado" => $usuarioConsultado,"url_qr" => $url_qr_publica, "estadisticas" => $estadisticas];
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