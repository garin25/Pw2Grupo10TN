<?php

class JuegoModel
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

    public function buscarPregunta($categoria, $dificultad, $preguntaId){

        if ($dificultad == "Dificil"){
            $sql = "SELECT *, (p.respondidasMal / p.cantidadEnviada) as dificultad FROM pregunta p 
                JOIN respuesta r ON r.preguntaId = p.preguntaId
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                    AND dificultad < ?
                    AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";
            $tipos = "si";
            $params = array($categoria, 0.33, $preguntaId);
            return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];
        }

        if ($dificultad == "Medio"){
            $sql = "SELECT *, (p.respondidasMal / p.cantidadEnviada) as dificultad FROM pregunta p 
                JOIN respuesta r ON r.preguntaId = p.preguntaId
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                    AND dificultad BETWEEN ? AND ? 
                    AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";
            $tipos = "sii";
            $params = array($categoria, 0.33, 0,66);
            return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];
        }

        if ($dificultad == "Facil"){
            $sql = "SELECT *, (p.respondidasMal / p.cantidadEnviada) as dificultad FROM pregunta p 
                JOIN respuesta r ON r.preguntaId = p.preguntaId
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                    AND dificultad > ?
                    AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";
            $tipos = "si";
            $params = array($categoria, 0.66);
            return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];
        }

        return null;
    }

    public function finalizarPartida($puntosPartida, $usuarioId){

        $sql = "INSERT INTO partida (usuarioId, puntos, fecha) VALUES (?, ?, ?)";
        $tipos = "sis";
        $params = array($usuarioId, $puntosPartida, date("Y-m-d H:i:s", time()));
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

}
