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

    /*public function procesarRegistro(){

        $nombreCompleto = $_POST['nombreCompleto'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $nombre_usuario = $_POST['nombre_usuario'] ?? '';
        $sexo = $_POST['sexo'] ?? '';
        $año = $_POST['año'] ?? '';
        $pais = $_POST['pais'] ?? '';
        $ciudad = $_POST['ciudad'] ?? '';

        if($nombreCompleto == "" || $email == "" || $password == ""||$nombre_usuario==""||
        $sexo==""||$año==""||$pais==""||$ciudad==""){
            $data['error'] = "Todos los campos son obligatorios.";
            $this->renderer->render("registrarse", $data);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->model->crearUsuario($nombreCompleto, $email, $passwordHash,$nombre_usuario,$sexo,$año,$pais,$ciudad);

        header('Location: /login');
        exit();

    }*/
    public function procesarRegistro(){
        // Recolectamos los datos y eliminamos espacios en blanco
        $nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? ''; // No hacemos trim a la contraseña
        $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
        $sexo = $_POST['sexo'] ?? '';
        // SOLUCIÓN AL BUG: Convertimos el año a un entero desde el principio
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

            echo "<h1>Depuración: La validación ha fallado.</h1>";
            echo "<p>El script se detuvo antes de intentar registrar al usuario.</p>";
            echo "<p>El error detectado es:</p>";
            echo "<pre style='background-color: #f8d7da; padding: 15px;'>";
            var_dump($data); // Muestra el contenido del array de error
            echo "</pre>";
            die();
            
            $this->renderer->render("registrarse", $data);
            return;
        }

        // Si todo está bien, procedemos a crear el usuario
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->model->crearUsuario($nombreCompleto, $email, $passwordHash, $nombre_usuario, $sexo, $año, $pais, $ciudad);

        // Opcional: Redirigir con un mensaje de éxito
       // header('Location: /login?exito=1');
        exit();
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}