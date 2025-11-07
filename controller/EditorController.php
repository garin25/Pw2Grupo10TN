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
        // 1. Validar sesión (como ya haces)
        if (!isset($_SESSION['usuarioId'])) { $this->redirectToIndex(); }

        // 2. Recoger todos los datos del POST
        $preguntaId = $_POST['preguntaId'];
        $enunciado = $_POST['enunciado'];
        $categoriaNombre = $_POST['categoria']; // Necesitarás el ID de la categoría
        $respuestas = $_POST['respuestas']; // Este es el array de respuestas
        $idRespuestaCorrecta = $_POST['rtaCorrecta']; // Este es el ID de la correcta


        // 3. Llamar al modelo para actualizar todo
        $exito = $this->model->actualizarPreguntaYRespuestas(
            $preguntaId,
            $enunciado,
            $categoriaNombre,
            $respuestas,
            $idRespuestaCorrecta
        );

        // 4. Crear mensaje "flash" en la sesión
        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Pregunta actualizada correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error: No se pudo actualizar la pregunta.";
        }

        // 5. Redirigir de vuelta a la página anterior
        header("Location: /editor/paginaEditarPregunta?preguntaId=" . $preguntaId);
        exit;
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
            "pregunta" => $pregunta,"respuestas"=> $respuestas,"categorias" => $categorias];

        if (isset($_SESSION['mensaje_exito'])) {
            $data['mensaje_exito'] = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']); // Borrarlo para que no aparezca de nuevo
        }

        // Revisar si hay un mensaje de error
        if (isset($_SESSION['mensaje_error'])) {
            $data['mensaje_error'] = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $this->renderer->render("editarPregunta", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }


}