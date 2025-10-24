<?php

class LoginController
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
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }

        $data = ["page" => "Iniciar Sesión", "registro" => "/register"];
        $this->renderer->render("login", $data);
    }

    public function verificarEmail()
    {
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if (!isset($datos['email']) || $datos['email'] == "") {
            $respuesta = ['ok' => false, 'error' => 'Ingrese su email.'];
            echo json_encode($respuesta);
            return;
        }

        $email = $datos['email'];
        $usuarioDatos = $this->model->obtenerIdUsuarioPorEmail($email);

        if ($usuarioDatos !== null) {
            $respuesta = [
                "ok" => true,
                "usuarioId" => $usuarioDatos['usuarioId'],        // <--- Clarifica la clave
                "nombre_usuario" => $usuarioDatos['nombre_usuario'] // <--- Añade el nombre
            ];
        } else {
            $respuesta = [
                "ok" => false,
                "error" => "Email no encontrado."
            ];
        }

        echo json_encode($respuesta);
    }

    public function verificarPass()
    {

        if (isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }

        header('Content-Type: application/json');

        $json_crudo = file_get_contents('php://input');

        $datos = json_decode($json_crudo, true);

        if (!isset($datos['pass']) || $datos['pass'] == "") {
            $respuesta = ['ok' => false, 'error' => 'Ingrese su contraseña.'];
            echo json_encode($respuesta);
            return;
        }

        $usuarioId = $datos['usuarioId'];
        $pass = $datos['pass'];
        $passLimpia = trim($pass);
        $usuario = $this->model->iniciarSesion($usuarioId, $passLimpia);

        if ($usuario !== null) {
            $_SESSION['usuarioId'] = $usuario['usuarioId'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $respuesta = [
                "ok" => true,
                "usuario" => $usuario
            ];
        } else {
            $respuesta = [
                "ok" => false,
                "error" => "Contraseña incorrecta."
            ];
        }

        echo json_encode($respuesta);
    }

    public function logout()
    {
        session_destroy();
        header("Location: /");
        exit;
    }

    public function redirectToIndex()
    {
        header("Location: /lobby");
        exit;
    }

}

