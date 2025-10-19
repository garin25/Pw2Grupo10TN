<?php

class RegisterModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function crearUsuario($nombreCompleto, $email, $passwordHash,$nombre_usuario,$sexo,$año,$pais,$ciudad){
        $sql = "INSERT INTO usuario (nombre_completo, anio_nacimiento, sexo, pais,ciudad,email,password,nombre_usuario,id_rol) VALUES (?,?,?,?,?,?,?,?,?)";
        $this->conexion->registrarUsuario($sql, $nombreCompleto,$año,$sexo,$pais,$ciudad,$email,$passwordHash,$nombre_usuario,1);
    }
    public function usuarioYaExiste($nombre_usuario, $email) {
        return $this->conexion->usuarioYaExiste($nombre_usuario, $email);
    }


}