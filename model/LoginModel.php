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
        $tipos = "s";
        $params = array($email);
        $result = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        if($result != null){
            return $result[0];
        }

        return null;

    }

    public function iniciarSesion($idUsuario, $pass){
        $sql = "SELECT usuarioId, nombre_usuario, password FROM usuario WHERE usuarioId = ?";
        $tipos = "i";
        $params = array($idUsuario);
        $usuario = $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

        if ($usuario === null) {
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