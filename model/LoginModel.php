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
        $sql = "SELECT usuarioId, user FROM usuario WHERE email = ?";
        return $this->conexion->obtenerIdUsuario($sql, $email);

    }

    public function iniciarSesion($idUsuario, $pass){
        $sql = "SELECT usuarioId, user FROM usuario WHERE usuarioId = ? AND password = ?";
        return $this->conexion->verificarInicioSesion($sql, $idUsuario, $pass);
    }
}