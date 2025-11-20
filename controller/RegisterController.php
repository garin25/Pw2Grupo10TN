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

    public function procesarRegistro()
    {
        if (isset($_SESSION['usuarioId'])) {
            $this->redirectToLobby();
        }

        // Recolectamos los datos y eliminamos espacios en blanco
        $nombreCompleto = trim($_POST['nombreCompleto'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? ''; // No hacemos trim a la contraseña
        $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
        $sexo = $_POST['sexo'] ?? '';
        $anio = (int)($_POST['año'] ?? 0);
        $pais = trim($_POST['pais'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');
        $latitud = $_POST['latitud'] ?? null;
        $longitud = $_POST['longitud'] ?? null;

        $foto = $_FILES['foto'] ?? null;

        $urlFoto = $this->subirFoto($foto);

        if($urlFoto===null){
            $data['error'] = "Ocurrio un error al subir la foto de perfil";
        }



        $data = []; // Array para acumular errores

        // --- Validación de datos ---
        if (empty($nombreCompleto) || empty($email) || empty($password) || empty($nombre_usuario) || empty($sexo)
            || empty($anio) || empty($pais) || empty($ciudad)|| empty($latitud) || empty($longitud)) {
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
        // Genera un token criptográficamente seguro de 64 caracteres
        $token = bin2hex(random_bytes(32));
        $this->model->crearUsuario($nombreCompleto, $email, $passwordHash, $nombre_usuario, $sexo, $anio, $pais, $ciudad,$token,$latitud,$longitud,$urlFoto);

        header("Location: /register/activacion");

        exit();
    }
    public function activar(){
        if (isset($_SESSION['usuarioId'])){
            $this->redirectToLobby();
        }

        $token = $_GET['token'] ?? null;
        if(!$token) {
            $this->redirectToLobby();
        }

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

    public function subirFoto($foto) {
        // 1. Verificar si llegó el archivo
        if (!isset($foto) || $foto['error'] != UPLOAD_ERR_OK) {
            // Manejo de errores (vacío, o error de subida)
            // $_SESSION['error'] = "Error al subir imagen";
            return null;
        }


        // 2. Definir la carpeta de destino usando DOCUMENT_ROOT
        // $_SERVER['DOCUMENT_ROOT'] te lleva a C:/xampp/htdocs (o la raíz de tu host)
        // Si tu proyecto está en una subcarpeta, asegúrate de incluirla o que la ruta sea correcta.

        // RUTA FÍSICA (Para que PHP guarde el archivo)
        // Ejemplo: C:/xampp/htdocs/mi_proyecto/imagenes/
        $carpetaDestino = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/';

        // 3. Crear la carpeta si no existe (y darle permisos)
        if (!is_dir($carpetaDestino)) {
            mkdir($carpetaDestino, 0777, true);
        }

        // 4. Generar un nombre ÚNICO para la imagen
        // Esto es vital. Si dos usuarios suben "perfil.jpg", uno borrará al otro.
        // Usamos el tiempo + un numero aleatorio + la extensión original.
        $extension = pathinfo($foto['name'], PATHINFO_EXTENSION);
        $nombreArchivo = 'perfil_' . uniqid() . '.' . $extension;

        // 5. Ruta completa final para guardar
        $rutaFisicaCompleta = $carpetaDestino . $nombreArchivo;

        // 6. Mover el archivo
        $subido = move_uploaded_file($foto['tmp_name'], $rutaFisicaCompleta);

        if ($subido) {
            // 7. ¡ÉXITO! Ahora guardamos la RUTA WEB en la base de datos
            // NO guardes "C:/xampp...", guarda lo que el navegador necesita ver.

            $rutaParaBaseDeDatos = 'imagenes/' . $nombreArchivo;

            return $rutaParaBaseDeDatos;

        } else {
            // Fallo al mover (permisos, ruta incorrecta, etc.)
            // echo "Error al guardar en: " . $rutaFisicaCompleta;
            return null;
        }
    }
}