<?php

class LoginModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }
    public function obtenerIdUsuarioPorEmail($email)
    {
        $sql = "SELECT usuarioId, nombre_usuario FROM usuario WHERE email = ?";
        return $this->obtenerIdUsuario($sql, $email);

    }

    public function iniciarSesion($idUsuario, $pass){
        $sql = "SELECT usuarioId, nombre_usuario, password FROM usuario WHERE usuarioId = ?";

        $usuario = $this->obtenerUsuarioPorId($sql, $idUsuario);

        if ($usuario===null) {
            return null;
        }

        $hash = $usuario["password"];
        if(password_verify($pass, $hash)){
            unset($usuario['password']);
            return $usuario;
        } else {
            return null;
        }
    }

    public function obtenerIdUsuario($sql, $email)
    {
        $stmt = $this->conexion->getConexion()->prepare($sql);
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
        $stmt = $this->conexion->getConexion()->prepare($sql);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $fila = $resultado->fetch_assoc();
            return $fila;
        }

        return null;
    }

}