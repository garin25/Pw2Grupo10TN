<?php

class MyConexion
{

    private $conexion;

    public function __construct($server, $user, $pass, $database)
    {
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
    public function obtenerUsuarioPorId($sql, $usuarioId){
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

    public function registrarUsuario($sql, $nombreCompleto, $año, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, $id_rol) {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sissssssi", $nombreCompleto, $año, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, $id_rol);
            $stmt->execute();
            $stmt->close();
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
