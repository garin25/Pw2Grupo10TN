<?php

class EditorController
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
        $this->abmPregunta();
    }

    public function abmPregunta()
    {
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $preguntas = $this->model->traerPreguntas();

        $data = ["page" => "abmPregunta", "logout" => "/login/logout", "usuario" => $usuario,"preguntas" => $preguntas];
        $this->renderer->render("abmPregunta", $data);
    }

    public function editarPregunta()
    {
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $preguntaId = $_POST['preguntaId'] ?? '';
        $enunciado = trim($_POST['enunciado'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');

        $this->model->editarPregunta($preguntaId,$enunciado,$categoria);

        $data = ["page" => "abmPregunta", "logout" => "/login/logout", "usuario" => $usuario];
        $this->renderer->render("abmPregunta", $data);
    }

    public function eliminarPregunta()
    {
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $preguntaId = $_POST['preguntaId'] ?? null;

        if ($preguntaId) {
            $this->model->eliminarPregunta($preguntaId);
        }
        header("Location: /editor");
        exit;
    }

    public function paginaCrearPregunta()
    {
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $data = ["page" => "crearPregunta", "logout" => "/login/logout", "usuario" => $usuario];
        $this->renderer->render("crearPregunta", $data);
    }

    public function paginaEditarPregunta()
    {
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $preguntaId = $_GET['preguntaId'] ?? '';

        $pregunta = $this->model->buscarPregunta($preguntaId)[0];
        $respuestas = $this->model->buscarRespuestas($preguntaId);
        // esto es por si agregamos mas categorias para que sea dinamico:
        $categorias = $this->model->traerCategorias();

        $data = ["page" => "editarPregunta", "logout" => "/login/logout", "usuario" => $usuario,
            "pregunta" => $pregunta,"rta1" => $respuestas[0],"rta2" => $respuestas[1]
            ,"rta3" => $respuestas[2],"rta4" => $respuestas[3],"categorias" => $categorias];
        $this->renderer->render("editarPregunta", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }


}