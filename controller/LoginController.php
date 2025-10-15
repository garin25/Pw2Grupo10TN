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
        $data = ["page" => "Iniciar Sesión"];
        $this->renderer->render("login", $data);
    }

    public function login()
    {
        /*$resultado = $this->model->getUserWith($_POST["usuario"], $_POST["password"]);

        if (sizeof($resultado) > 0) {
            $_SESSION["usuario"] = $_POST["usuario"];
            $this->redirectToIndex();
        } else {
            $this->renderer->render("login", ["error" => "Usuario o clave incorrecta"]);
        }*/
    }

    public function logout()
    {
        session_destroy();
        $this->redirectToIndex();
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}

