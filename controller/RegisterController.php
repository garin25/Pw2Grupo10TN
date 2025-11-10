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
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
        }

        $data = [
            "page" => "Registrarse", "login" => "/login"];
        $this->renderer->render("registrarse", $data);
    }
    public function activacion()
    {
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
        }

        $data = [
            "page" => "activacion"
        ];
        $this->renderer->render("activacion", $data);
    }

    public function resultadoActivacion()
    {
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
        }

        $exito = $_GET['exito'] ?? 0;

        $data = [
            "page" => "Resultado de Activación"
        ];

        // Pasamos una bandera de éxito o de fallo según el parámetro
        if ($exito == 1) {
            $data['activacionExitosa'] = true;
        } else {
            $data['activacionFallida'] = true;
        }
        $this->renderer->render("resultadoActivacion", $data);
    }

    public function procesarRegistro(){
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
        }

        // Recolectamos los datos y eliminamos espacios en blanco
        $nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
        $sexo = $_POST['sexo'] ?? '';
        $anio = (int)($_POST['año'] ?? 0);
        $pais = trim($_POST['pais'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');

        $data = []; // Array para acumular errores

        if (empty($nombreCompleto) || empty($email) || empty($password) || empty($nombre_usuario) || empty($sexo) || empty($anio) || empty($pais) || empty($ciudad)) {
            $data['error'] = "Todos los campos son obligatorios.";
        } elseif (strlen($password) < 8) {
            $data['error'] = "La contraseña debe tener al menos 8 caracteres.";
        } elseif ($password !== $confirm_password) {
            $data['error'] = "Las contraseñas no coinciden.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data['error'] = "El formato del email no es válido.";
        } elseif ($this->model->usuarioYaExiste($nombre_usuario, $email)) {
            $data['error'] = "El nombre de usuario o el email ya están registrados.";
        }

        $rutaFotoPerfil = '/imagenes/img-perfil-default.jpg'; // Valor por defecto

        if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] == UPLOAD_ERR_OK) {

            $carpetaSubidas = $_SERVER['DOCUMENT_ROOT'] . '/uploads/perfiles/';
            $archivoTemporal = $_FILES['fotoPerfil']['tmp_name'];

            $limiteTamano = 5 * 1024 * 1024;
            $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
            $tipoArchivo = mime_content_type($archivoTemporal);

            if ($_FILES['fotoPerfil']['size'] > $limiteTamano) {
                $data['error'] = "La imagen es demasiado grande (máximo 5MB).";
            } elseif (!in_array($tipoArchivo, $tiposPermitidos)) {
                $data['error'] = "Tipo de archivo no permitido (solo JPG, PNG, GIF).";
            } else {
                $extension = pathinfo($_FILES['fotoPerfil']['name'], PATHINFO_EXTENSION);
                $nombreUnico = uniqid('user_') . '.' . $extension;

                $rutaDestinoFisica = $carpetaSubidas . $nombreUnico;

                if (move_uploaded_file($archivoTemporal, $rutaDestinoFisica)) {
                    $rutaFotoPerfil = '/uploads/perfiles/' . $nombreUnico;
                } else {
                    $data['error'] = "Error al guardar la imagen de perfil.";
                }
            }

        } elseif (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] != UPLOAD_ERR_NO_FILE) {
            $data['error'] = "Hubo un error al subir la foto de perfil.";
        }


        if (!empty($data['error'])) {
            $data['nombreCompleto'] = $nombreCompleto;
            $data['email'] = $email;
            $data['nombre_usuario'] = $nombre_usuario;
            $data['sexo'] = $sexo;
            $data['año'] = $anio;
            $data['pais'] = $pais;
            $data['ciudad'] = $ciudad;
            $data['login'] = "/login";

            $this->renderer->render("registrarse", $data);
            return;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(32)); // Token de 64 caracteres

        $this->model->crearUsuario(
            $nombreCompleto,
            $email,
            $passwordHash,
            $nombre_usuario,
            $sexo,
            $anio,
            $pais,
            $ciudad,
            $token,
            $rutaFotoPerfil
        );

        header("Location: /register/activacion?token=" . $token);
        exit();
    }
    public function activar(){
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
        }

        $token = trim($_POST['token'] ?? '');
        $exitoso = $this->model->activar($token);

        if ($exitoso) {
            header("Location: /register/resultadoActivacion?exito=1");
        } else {
            header("Location: /register/resultadoActivacion?exito=0");
        }
        exit();
    }

    public function redirectToLobby()
    {
        header("Location: /");
        exit;
    }

}