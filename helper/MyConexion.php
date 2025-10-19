<?php

class MyConexion
{

    private $conexion;

    public function __construct($server, $user, $pass, $database)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        $this->conexion = new mysqli($server, $user, $pass, $database);
        if ($this->conexion->error) { die("Error en la conexión: " . $this->conexion->error); }
    }

    public function query($sql)
    {
        $result = $this->conexion->query($sql);
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return null;
    }
    public function obtenerIdUsuario($sql, $email)
    {
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            return $fila;
        }

        return null;
    }

  /* public function verificarInicioSesion($sql, $usuarioId, $pass){
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("is", $usuarioId, $pass);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            return $fila;
        }

        return null;
    }*/
    // se llamaria obtenerUsuarioPorId en realidad
    public function verificarInicioSesion($sql, $usuarioId){
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            return $fila;
        }

        return null;
    }

    /*public function registrarUsuario($sql, $nombreCompleto,$año,$sexo,$pais,$ciudad,$email,$passwordHash,$nombre_usuario,$id_rol){
        $stmt = $this->conexion->prepare($sql);

        //Verifico Stmt
        if ($stmt === false) {
            // Muestra el error de la preparación de la consulta
            die('Error al preparar la consulta: ' . $this->conexion->error);
        }

        $stmt->bind_param("sissssssi", $nombreCompleto, $año, $sexo, $pais,$ciudad,$email,$passwordHash,$nombre_usuario,$id_rol);

       if(!$stmt->execute()){

           echo "<h1>Error al ejecutar la consulta:</h1>";
           echo "<p><strong>Mensaje de error:</strong> " . $stmt->error . "</p>";
           echo "<p><strong>Código de error:</strong> " . $stmt->errno . "</p>";
           $stmt->close();
       }
        $stmt->close();
    }*/

    // En tu clase MyConexion.php
    public function registrarUsuario($sql, $nombreCompleto, $año, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, $id_rol) {

        try {
            // 1. Intentamos preparar la consulta
            $stmt = $this->conexion->prepare($sql);

            // Esta comprobación es opcional con mysqli_report, pero es una buena práctica
            if ($stmt === false) {
                // Esto no debería pasar si mysqli_report está activo, pero por si acaso
                throw new Exception("Error al preparar la consulta: " . $this->conexion->error);
            }

            // 2. Intentamos vincular los parámetros
            $stmt->bind_param("sissssssi", $nombreCompleto, $año, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, $id_rol);

            // 3. Intentamos ejecutar la consulta
            $stmt->execute();

            $stmt->close();

            // Si llegamos aquí, todo funcionó
            return true;

        } catch (Exception $e) {
            // SI ALGO FALLA en cualquiera de los pasos anteriores, el código salta aquí.

            echo "<h1>⛔ Error Fatal en la Base de Datos ⛔</h1>";
            echo "<p>No se pudo registrar al usuario. El problema es:</p>";
            echo "<pre style='background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; color: #721c24;'>";
            // La variable $e contiene el mensaje de error EXACTO de MySQL
            echo "<strong>Mensaje:</strong> " . $e->getMessage();
            echo "</pre>";

            // También es muy útil registrar esto en un archivo para que no lo vean los usuarios finales
            error_log("Error de registro: " . $e->getMessage());

            return false; // Indicamos que el registro falló
        }
    }

    public function usuarioYaExiste($nombre_usuario, $email) {
        $sql = "SELECT usuarioId FROM usuario WHERE nombre_usuario = ? OR email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre_usuario, $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        // Si encontró alguna fila, significa que el usuario ya existe
        return $resultado->num_rows > 0;
    }
}
