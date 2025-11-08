<?php

class PerfilModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarDatosUsuario($usuarioNombre){

        $sql = "SELECT * FROM usuario WHERE nombre_usuario = ?";
        $tipos = "s";
        $params = array($usuarioNombre);

        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

    }

    public function buscarDatosUsuarioPorId($usuarioId){

        $sql = "SELECT * FROM usuario WHERE usuarioid = ?";
        $tipos = "s";
        $params = array($usuarioId);

        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

    }

}