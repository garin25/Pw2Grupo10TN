<?php

class RegisterController
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
        $this->registrar();
    }

    public function registrar()
    {
        $this->renderer->render("registrarse");
    }

    public function procesarRegistro(){

        $nombreCompleto = $_POST['nombreCompleto'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if($nombreCompleto == "" || $email == "" || $password == ""){
            $data['error'] = "Todos los campos son obligatorios.";
            $this->renderer->render("registrarse", $data);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->model->crearUsuario($nombreCompleto, $email, $passwordHash);

        header('Location: /login');
        exit();

    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}