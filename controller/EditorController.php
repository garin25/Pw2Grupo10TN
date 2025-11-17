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
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $preguntas = $this->model->traerPreguntas();

        $data = ["page" => "abmPregunta", "logout" => "/login/logout", "usuario" => $usuario,"preguntas" => $preguntas];

        // Agrego mensaje de exito o error por si hizo una operacion
        if (isset($_SESSION['mensaje_exito'])) {
            $data['mensaje_exito'] = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']); // Borrarlo para que no aparezca de nuevo
        }

        // Revisar si hay un mensaje de error
        if (isset($_SESSION['mensaje_error'])) {
            $data['mensaje_error'] = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }
        $this->renderer->render("abmPregunta", $data);
    }

    public function crearPregunta()
    {

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $enunciado = $_POST['enunciado'];
        $categoriaNombre = $_POST['categoria'];
        $respuestas = $_POST['respuestas'];
        $indiceCorrecto = $_POST['rtaCorrecta'];


        $exito = $this->model->crearPregunta(
            $enunciado,
            $categoriaNombre,
            $respuestas,
            $indiceCorrecto
        );


        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Pregunta creada correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error: No se pudo creada la pregunta.";
        }

        header("Location: /editor/paginaCrearPregunta");
        exit;
    }


    public function editarPregunta()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $preguntaId = $_POST['preguntaId'];
        $enunciado = $_POST['enunciado'];
        $categoriaNombre = $_POST['categoria'];
        $respuestas = $_POST['respuestas'];
        $idRespuestaCorrecta = $_POST['rtaCorrecta'];


        $exito = $this->model->actualizarPreguntaYRespuestas(
            $preguntaId,
            $enunciado,
            $categoriaNombre,
            $respuestas,
            $idRespuestaCorrecta
        );


        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Pregunta actualizada correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error: No se pudo actualizar la pregunta.";
        }

        header("Location: /editor/paginaEditarPregunta?preguntaId=" . $preguntaId);
        exit;
    }

    public function eliminarPregunta()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }
        $preguntaId = $_POST['preguntaId'] ?? null;

        if ($preguntaId) {
          $exito =  $this->model->eliminarPregunta($preguntaId);
        }
        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Pregunta eliminada correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error: No se pudo eliminar la pregunta.";
        }
        header("Location: /editor");
        exit;
    }

    public function paginaCrearPregunta()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $categorias = $this->model->traerCategorias();

        $data = ["page" => "crearPregunta", "logout" => "/login/logout", "usuario" => $usuario ,"categorias" => $categorias];

        if (isset($_SESSION['mensaje_exito'])) {
            $data['mensaje_exito'] = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']); // Borrarlo para que no aparezca de nuevo
        }

        // Revisar si hay un mensaje de error
        if (isset($_SESSION['mensaje_error'])) {
            $data['mensaje_error'] = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $this->renderer->render("crearPregunta", $data);
    }

    public function paginaEditarPregunta()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $preguntaId = $_GET['preguntaId'] ?? '';

        $pregunta = $this->model->buscarPregunta($preguntaId)[0];
        $respuestas = $this->model->buscarRespuestas($preguntaId);
        // esto es por si agregamos mas categorias para que sea dinamico:
        $categorias = $this->model->traerCategorias();

        // Le pasamos a la vista la categoria actual asi la selecciona en el select
        $categoriaActualId = $pregunta['categoriaId'];

        $categoriasProcesadas = [];
        foreach ($categorias as $categoria) {
            // guarda en la clave is_select true cuando es la categoria actual , si no false
            $categoria['is_selected'] = ($categoria['categoriaId'] == $categoriaActualId);
            $categoriasProcesadas[] = $categoria;
        }

        $data = ["page" => "editarPregunta", "logout" => "/login/logout", "usuario" => $usuario,
            "pregunta" => $pregunta,"respuestas"=> $respuestas,"categorias" => $categoriasProcesadas];

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

    public function buscarCategorias() {
        $categorias = $this->model->traerCategorias();
        $data = ["categorias" => $categorias];
        echo json_encode($data);
}


    public function paginaReportes()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $reportes = $this->model->traerPreguntasyCantidadDeReportes();
        $data = ["page" => "reportes", "logout" => "/login/logout", "usuario" => $usuario,"reportes"=> $reportes];
        $this->renderer->render("reportes", $data);
    }

    public function detalleReporte()
    {

        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];
        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $preguntaId = $_GET['preguntaId'] ?? '';
        $reportes = $this->model->traerReportes($preguntaId);

        $respuestas = $this->model->buscarRespuestas($preguntaId);

        $data = ["page" => "reportes", "logout" => "/login/logout", "usuario" => $usuario,"reportes"=> $reportes ,
            "preguntaId" => $preguntaId,"enunciado"=>$reportes[0]["enunciado"],"respuestas"=>$respuestas];


        if (isset($_SESSION['mensaje_exito'])) {
            $data['mensaje_exito'] = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']); // Borrarlo para que no aparezca de nuevo
        }

        // Revisar si hay un mensaje de error
        if (isset($_SESSION['mensaje_error'])) {
            $data['mensaje_error'] = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $this->renderer->render("detalleReporte", $data);
    }

    public function denegarReporte()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }
        $reportesId = $_POST['reportesId'] ?? null;
        $preguntaId = $_POST['preguntaId'] ?? '';

        if ($reportesId) {
           $exito = $this->model->eliminarReporte($reportesId);
        }

        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Reporte denegado correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error: No se pudo denegar el reporte.";
        }

        //header("Location: /editor/detalleReporte?preguntaId=".$preguntaId);
        header("Location: /editor/paginaReportes");
        exit;
    }
    public function paginaUsuarios(){
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $usuarioId = $_SESSION['usuarioId'];

        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $usuarios = $this->model->traerJugadores();

        $usuariosProcesados = [];
        foreach ($usuarios as $u) {
            // Creamos las flags booleanas que Mustache necesita para el 'selected'
            $u['rol_es_jugador'] = ($u['id_rol'] == 1);
            $u['rol_es_editor'] = ($u['id_rol'] == 2);
            $u['rol_es_admin'] = ($u['id_rol'] == 3);
            $usuariosProcesados[] = $u;
        }

        $esAdmin = ($_SESSION['id_rol'] == 3);

        $data = [
            "page" => "usuariosVista",
            "logout" => "/login/logout",
            "usuario" => $usuario,
            "usuarios" => $usuariosProcesados,
            "es_admin" => $esAdmin
        ];

        if (isset($_SESSION['mensaje_exito'])) {
            $data['mensaje_exito'] = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']);
        }

        if (isset($_SESSION['mensaje_error'])) {
            $data['mensaje_error'] = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $this->renderer->render("usuarios", $data);
    }

    public function cambiarRol(){
        if (!isset($_SESSION['usuarioId'])) {
            $this->redirectToIndex();
        }
        $usuarioId = $_POST['usuarioId'] ?? '';
        $nuevoRol = $_POST['nuevoRol'] ?? '';

        if ($usuarioId && $nuevoRol) {
            $exito =  $this->model->actualizarRolUsuario($usuarioId, $nuevoRol);
        }

        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Rol actualizado correctamente a:" . " " . $nuevoRol;
        } else {
            $_SESSION['mensaje_error'] = "Error: No se pudo cambiar el rol.";
        }

        header("Location: /editor/paginaUsuarios");
        exit;
    }

    public function paginaCategorias()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $usuarioId = $_SESSION['usuarioId'];
        $usuario = $this->model->buscarDatosUsuario($usuarioId); // Para el header

        $categorias = $this->model->traerCategorias();

        $data = ["page" => "Gestión de Categorías",
            "logout" => "/login/logout",
            "usuario" => $usuario,
            "categorias" => $categorias];

        if (isset($_SESSION['mensaje_exito'])) {
            $data['mensaje_exito'] = $_SESSION['mensaje_exito'];
            unset($_SESSION['mensaje_exito']);
        }
        if (isset($_SESSION['mensaje_error'])) {
            $data['mensaje_error'] = $_SESSION['mensaje_error'];
            unset($_SESSION['mensaje_error']);
        }

        $this->renderer->render("gestionCategorias", $data);
    }

    public function paginaCrearCategoria()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $usuarioId = $_SESSION['usuarioId'];
        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $data = ["page" => "Crear Categoría",
            "logout" => "/login/logout",
            "usuario" => $usuario];

        $this->renderer->render("crearCategoria", $data);
    }

    public function crearCategoria()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $nombre = $_POST['nombre'] ?? '';
        $color = $_POST['color'] ?? '#FFFFFF';
        $imagen = $_FILES['ruta_imagen'];

        $ruta_para_bd = '';

        if (isset($imagen) && $imagen['error'] == 0) {
            $directorio_destino = "imagenes/";
            if (!file_exists($directorio_destino)) {
                mkdir($directorio_destino, 0777, true);
            }

            // Creamos un nombre de archivo único para evitar sobreescribir
            $nombre_archivo = uniqid() . '-' . basename($imagen['name']);
            $ruta_completa_archivo = $directorio_destino . $nombre_archivo;

            // Movemos el archivo de la carpeta temporal a nuestro directorio
            if (move_uploaded_file($imagen['tmp_name'], $ruta_completa_archivo)) {
                $ruta_para_bd = "/" . $ruta_completa_archivo;
            }
        }

        if (!empty($nombre) && !empty($ruta_para_bd)) {
            $exito = $this->model->crearCategoria($nombre, $color, $ruta_para_bd);
            if ($exito) {
                $_SESSION['mensaje_exito'] = "¡Categoría creada correctamente!";
            } else {
                $_SESSION['mensaje_error'] = "Error al crear la categoría.";
            }
        } else {
            $_SESSION['mensaje_error'] = "Faltan datos (nombre o imagen).";
        }

        header("Location: /editor/paginaCategorias");
        exit;
    }

    public function paginaEditarCategoria()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $idCategoria = $_GET['id'] ?? 0;

        $categoria = $this->model->traerCategoriaPorId($idCategoria);

        if ($categoria == null) {
            $_SESSION['mensaje_error'] = "Categoría no encontrada.";
            header("Location: /editor/paginaCategorias");
            exit;
        }

        $usuarioId = $_SESSION['usuarioId'];
        $usuario = $this->model->buscarDatosUsuario($usuarioId);

        $data = ["page" => "Editar Categoría",
            "logout" => "/login/logout",
            "usuario" => $usuario,
            "categoria" => $categoria];

        $this->renderer->render("editarCategoria", $data);
    }

    public function actualizarCategoria()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $idCategoria = $_POST['id'] ?? 0;
        $nombre = $_POST['nombre'] ?? '';
        $color = $_POST['color'] ?? '#FFFFFF';
        $imagen_actual = $_POST['imagen_actual'] ?? '';
        $nueva_imagen = $_FILES['ruta_imagen'];

        $ruta_para_bd = $imagen_actual;

        if (isset($nueva_imagen) && $nueva_imagen['error'] == 0) {
            $directorio_destino = "imagenes/";
            if (!file_exists($directorio_destino)) {
                mkdir($directorio_destino, 0777, true);
            }

            $nombre_archivo = uniqid() . '-' . basename($nueva_imagen['name']);
            $ruta_completa_archivo = $directorio_destino . $nombre_archivo;

            if (move_uploaded_file($nueva_imagen['tmp_name'], $ruta_completa_archivo)) {
                $ruta_para_bd = "/" . $ruta_completa_archivo;

            }
        }

        $exito = $this->model->actualizarCategoria($idCategoria, $nombre, $color, $ruta_para_bd);

        if ($exito) {
            $_SESSION['mensaje_exito'] = "¡Categoría actualizada correctamente!";
        } else {
            $_SESSION['mensaje_error'] = "Error al actualizar la categoría.";
        }

        header("Location: /editor/paginaCategorias");
        exit;
    }

    public function eliminarCategoria()
    {
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 2) {
            $this->redirectToIndex();
        }

        $idCategoria = $_POST['id'] ?? 0;

        $conteo = $this->model->contarPreguntasPorCategoria($idCategoria);

        if ($conteo > 0) {
            $_SESSION['mensaje_error'] = "No se puede eliminar: La categoría tiene " . $conteo . " preguntas asociadas.";
        } else {

            $exito = $this->model->eliminarCategoria($idCategoria);
            if ($exito) {
                $_SESSION['mensaje_exito'] = "Categoría eliminada correctamente.";
            } else {
                $_SESSION['mensaje_error'] = "Error al eliminar la categoría.";
            }
        }

        header("Location: /editor/paginaCategorias");
        exit;
    }
    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }
}