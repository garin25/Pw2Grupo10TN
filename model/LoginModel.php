<?php

class LoginModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    /*public function obtenerIdUsuarioPorEmail($email)
    {
        $sql = "SELECT usuarioId, user FROM usuario WHERE email = ?";
        return $this->conexion->obtenerIdUsuario($sql, $email);

    }

    public function iniciarSesion($idUsuario, $pass){
        $sql = "SELECT usuarioId, user FROM usuario WHERE usuarioId = ? AND password = ?";
        return $this->conexion->verificarInicioSesion($sql, $idUsuario, $pass);
    }*/

    public function obtenerIdUsuarioPorEmail($email)
    {
        $sql = "SELECT usuarioId, nombre_usuario FROM usuario WHERE email = ?";
        return $this->conexion->obtenerIdUsuario($sql, $email);

    }

    public function iniciarSesion($idUsuario, $pass){
        $sql = "SELECT usuarioId, nombre_usuario, password FROM usuario WHERE usuarioId = ?";

        $usuario = $this->conexion->verificarInicioSesion($sql, $idUsuario);

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


}