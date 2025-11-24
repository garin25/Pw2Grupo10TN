<?php

class RankingModel
{

    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarDatosUsuario($usuarioId){

        $sql = "SELECT * FROM usuario WHERE usuarioid = ?";
        $tipos = "s";
        $params = array($usuarioId);

        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

    }

    public function buscarRanking(){

        $sql = "SELECT u.nombre_usuario, u.foto_perfil, MAX(p.puntos) AS puntos FROM usuario u 
                JOIN partida p ON u.usuarioId = p.usuarioid 
                WHERE p.puntos > 0
                GROUP BY u.nombre_usuario
                ORDER BY puntos DESC
                LIMIT ?";
        $tipos = "i";
        $params = array(10);
        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        if(count($resultado) > 0){
            return $resultado;
        }

        return null;
    }

}