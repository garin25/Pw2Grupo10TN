<?php

class MiPerfilController
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
        $this->miPerfil();
    }

    public function miPerfil()
    {
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION["usuarioId"];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $estadisticas = $this->model->obtenerEstadisticasDeJuego($usuarioId);
        $url_qr_publica = $usuario['img_qr'] ?? '';
        $data = ["page" => "Mi perfil", "logout" => "/login/logout", "usuario" => $usuario, "url_qr" => $url_qr_publica, "estadisticas" => $estadisticas];
        $this->renderer->render("miPerfil", $data);
    }

    public function editarPerfil() {
        if (!isset($_SESSION['usuarioId'])){
            $this->redirectToIndex();
        }


        if (!isset($_POST['nombreUsuario']) || $_POST['nombreUsuario'] == "" ){
            $respuesta = ["ok" => false, "error" => "form", "msj" => "Ingrese un nombre de usuario valido."];
            echo json_encode($respuesta);
            return;
        }

        $nombreUsuario = $_POST['nombreUsuario'];

        if (isset($_FILES['fotoPerfil'])){
            $urlFoto = $this->subirFoto($_FILES['fotoPerfil']);

            if ($urlFoto == null){
                $respuesta = ["ok" => false, "error" => "error", "msj" => "Error al subir imagen."];
                echo json_encode($respuesta);
                return;
            }

            $result = $this->model->actualizarDatosUsuario($_SESSION['usuarioId'], $nombreUsuario, $urlFoto);

            if($result > 0){
                $respuesta = ["ok" => true, "msj" => "Perfil actualizado.", "urlFoto" => $urlFoto];
                echo json_encode($respuesta);
            } else {
                $respuesta = ["ok" => false, "error" => "error", "msj" => "No se pudo actualizar el perfil."];
                echo json_encode($respuesta);
            }

        } else {

            $result = $this->model->actualizarNombreUsuario($_SESSION['usuarioId'], $nombreUsuario);

            if($result > 0){
                $respuesta = ["ok" => true, "msj" => "Perfil actualizado."];
                echo json_encode($respuesta);
            } else {
                $respuesta = ["ok" => false, "error" => "error", "msj" => "No se pudo actualizar el perfil."];
                echo json_encode($respuesta);
            }

        }

    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

    public function subirFoto($foto) {
        // 1. Verificar si llegó el archivo
        if (!isset($foto) || $foto['error'] != UPLOAD_ERR_OK) {

            return null;
        }

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