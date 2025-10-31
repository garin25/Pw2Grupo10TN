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

        // FIX: Validar que la consulta devuelva un resultado antes de acceder a [0]
        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);
        if (count($resultado) > 0) {
            return $resultado[0];
        }
        return null; // Si no se encuentra el usuario, devuelve null
    }

    public function buscarPregunta($categoria, $dificultad, $preguntaId){

        $resultado = []; // Inicializar variable

        if ($dificultad == "Dificil"){
            // FIX: Corregido el SQL para usar el cálculo en el WHERE en lugar del alias 'dificultad'
            $sql = "SELECT *, (p.respondidasMal / p.cantidadEnviada) as dificultad FROM pregunta p 
                JOIN respuesta r ON r.preguntaId = p.preguntaId
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                    AND (p.respondidasMal / p.cantidadEnviada) < ?
                    AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";
            // FIX: Corregidos tipos (sdii) y params (4) para que coincidan con los '?'
            $tipos = "sdii";
            $params = array($categoria, 0.66, $preguntaId, $preguntaId);
            $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);
        }

        if ($dificultad == "Medio"){
            // FIX: Corregido el SQL para usar el cálculo en el WHERE
            $sql = "SELECT *, (p.respondidasMal / p.cantidadEnviada) as dificultad FROM pregunta p 
                JOIN respuesta r ON r.preguntaId = p.preguntaId
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                    AND (p.respondidasMal / p.cantidadEnviada) BETWEEN ? AND ? 
                    AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";
            // FIX: Corregidos tipos (sddii), params (5) y el 0,66 por 0.66
            $tipos = "sddii";
            $params = array($categoria, 0.33, 0.66, $preguntaId, $preguntaId);
            $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);
        }

        if ($dificultad == "Facil"){
            // FIX: Corregido el SQL para usar el cálculo en el WHERE
            $sql = "SELECT *, (p.respondidasMal / p.cantidadEnviada) as dificultad FROM pregunta p 
                JOIN respuesta r ON r.preguntaId = p.preguntaId
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                    AND (p.respondidasMal / p.cantidadEnviada) > ?
                    AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";
            // FIX: Corregidos tipos (sdii) y params (4)
            $tipos = "sdii";
            $params = array($categoria, 0.33, $preguntaId, $preguntaId);
            $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);
        }

        // FIX: Validar que la consulta devuelva un resultado antes de acceder a [0]
        if (count($resultado) > 0) {
            return $resultado[0];
        }

        return null; // Si no se encontró pregunta, devuelve null
    }

    public  function buscarRespuestas($id)
    {
        $sqlRespuestas = "SELECT * FROM respuesta WHERE preguntaId = ?";
        return $this->conexion->ejecutarConsulta($sqlRespuestas, "i", [$id]);
    }

    // FIX: Cambiado el nombre a 'partidaFinalizada' para coincidir con el controlador
    public function partidaFinalizada($puntosPartida, $usuarioId){

        $sql = "INSERT INTO partida (usuarioId, puntos, fecha) VALUES (?, ?, ?)";
        $tipos = "sis"; // Asumiendo usuarioId es string, puntos es int, fecha es string
        $params = array($usuarioId, $puntosPartida, date("Y-m-d H:i:s", time()));
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

}