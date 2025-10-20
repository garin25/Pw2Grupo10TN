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
        $data = [
            "page" => "Registrarse", "login" => "/login"];
        $this->renderer->render("registrarse", $data);
    }
    public function procesarRegistro(){
        // Recolectamos los datos y eliminamos espacios en blanco
        $nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? ''; // No hacemos trim a la contraseña
        $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
        $sexo = $_POST['sexo'] ?? '';
        $año = (int)($_POST['año'] ?? 0);
        $pais = trim($_POST['pais'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');

        $data = []; // Array para acumular errores

        // --- Validación de datos ---
        if (empty($nombreCompleto) || empty($email) || empty($password) || empty($nombre_usuario) || empty($sexo) || empty($año) || empty($pais) || empty($ciudad)) {
            $data['error'] = "Todos los campos son obligatorios.";
        } elseif (strlen($password) < 8) {
            $data['error'] = "La contraseña debe tener al menos 8 caracteres.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['error'] = "El formato del email no es válido.";
        } elseif ($this->model->usuarioYaExiste($nombre_usuario, $email)) {
            $data['error'] = "El nombre de usuario o el email ya están registrados.";
        }

        // Si hubo algún error, volvemos a renderizar el formulario con el mensaje
        if (!empty($data['error'])) {
            $this->renderer->render("registrarse", $data);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $this->model->crearUsuario($nombreCompleto, $email, $passwordHash, $nombre_usuario, $sexo, $año, $pais, $ciudad);

        header('Location: /');

        exit();
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}