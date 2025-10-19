<?php

class RegisterModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function crearUsuario($nombreCompleto, $email, $passwordHash){
        $sql = "INSERT INTO usuario (nombreCompleto, user, email, password) VALUES (?, ?, ?, ?)";
        $this->conexion->registrarUsuario($sql, $nombreCompleto, $nombreCompleto, $email, $passwordHash);
    }


}