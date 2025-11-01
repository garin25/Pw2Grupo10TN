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
            $this->redirectToLobby();
        }

        $data = ["page" => "Iniciar Sesión", "registro" => "/register"];
        $this->renderer->render("login", $data);
    }

    public function verificarEmail()
    {
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
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
            $this->redirectToLobby();
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

        //Si se loguea le calculo el nivel al usuario
        $nivelUsuario = $this->model->calcularNivelUsuario($usuarioId); // Devuelve 0.0 para nuevos usuarios
        $dificultadString = $this->pasarNivelAString($nivelUsuario);
        $_SESSION['dificultad'] = $dificultadString;

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

    public function pasarNivelAString($nivelUsuario){
        if ($nivelUsuario < 0.33) {
            return "Facil";
        } else if ($nivelUsuario > 0.66) {
            // Es malo (cercano a 1) O es nuevo (default = 1.0) -> Dificil
            return "Dificil";
        } else {
            // Es promedio (entre 0.33 y 0.66) -> Medio
            return "Medio";
        }
    }


    public function logout()
    {
        session_destroy();
        header("Location: /");
        exit;
    }

    public function redirectToLobby()
    {
        header("Location: /lobby");
        exit;
    }

}

