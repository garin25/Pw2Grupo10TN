<?php

class MyConexion
{

    private $conexion;

    public function __construct($server, $user, $pass, $database)
    {
        $this->conexion = new mysqli($server, $user, $pass, $database);
        if ($this->conexion->error) { die("Error en la conexión: " . $this->conexion->error); }
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function ejecutarConsulta($sql, $tipos, $params) {

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        return null;
    }

    /*public function registrarUsuario($sql, $nombreCompleto, $año, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, $id_rol,$token) {
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("sissssssis", $nombreCompleto, $año, $sexo, $pais, $ciudad, $email, $passwordHash, $nombre_usuario, $id_rol,$token);
            $stmt->execute();
            $stmt->close();
    }*/

    /*public function usuarioYaExiste($nombre_usuario, $email) {
        $sql = "SELECT usuarioId FROM usuario WHERE nombre_usuario = ? OR email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ss", $nombre_usuario, $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        // Si encontró alguna fila, significa que el usuario ya existe
        return $resultado->num_rows > 0;
    }*/

    /*public function verificarUsuarioNoVerificado($sql,$token){
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        return $usuario;
    }*/

    /*public  function activar($usuario)
    {
        $usuarioId = $usuario['usuarioId'];
        $sql = "UPDATE usuario SET cuenta_verificada = true, token = NULL WHERE usuarioId = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
    }*/
}
