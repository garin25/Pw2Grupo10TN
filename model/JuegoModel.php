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

        // Usamos IF() de MySQL para evitar 100% la división por cero.
        // Si la pregunta es nueva (0/0), su ratio será 0 (Fácil).
        $ratioSeguro = "IF(p.cantidadEnviada = 0, 0, (p.respondidasMal / p.cantidadEnviada))";

        $condicionDificultad = "";

        // 1. Definimos el filtro SQL
        if ($dificultad == "Facil") {
            $condicionDificultad = "AND ($ratioSeguro < 0.33)";
        } elseif ($dificultad == "Medio") {
            $condicionDificultad = "AND ($ratioSeguro BETWEEN 0.33 AND 0.66)";
        } elseif ($dificultad == "Dificil") {
            $condicionDificultad = "AND ($ratioSeguro > 0.66)";
        }

        // 2. INTENTO 1: Buscar la pregunta con la dificultad específica
        $sql = "SELECT * FROM pregunta p 
                JOIN categoria c ON c.categoriaId = p.categoriaId
                WHERE c.nombre = ? 
                $condicionDificultad
                AND (p.preguntaId != ? OR ? IS NULL)
                ORDER BY RAND()
                LIMIT 1";

        $tipos = "sii";
        $params = array($categoria, $preguntaId, $preguntaId);
        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        // 3. ----- ESTA ES LA COMPROBACIÓN CORREGIDA -----
        // Comprobamos si $resultado es un array Y si no está vacío
        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado[0];
        }
        // ----------------------------------------------

        // 4. INTENTO 2 (FALLBACK): Si no encontramos nada,
        //    buscamos CUALQUIER pregunta de esa categoría que no esté repetida.

        $sqlFallback = "SELECT * FROM pregunta p 
                        JOIN categoria c ON c.categoriaId = p.categoriaId
                        WHERE c.nombre = ? 
                        AND (p.preguntaId != ? OR ? IS NULL)
                        ORDER BY RAND()
                        LIMIT 1";

        $resultadoFallback = $this->conexion->ejecutarConsulta($sqlFallback, $tipos, $params);

        // También usamos la comprobación segura aquí
        if (is_array($resultadoFallback) && count($resultadoFallback) > 0) {
            return $resultadoFallback[0];
        }

        // 5. Si ya no hay más preguntas en esa categoría, devolvemos null
        return null;
    }

    public  function buscarRespuestas($id)
    {
        $sqlRespuestas = "SELECT * FROM respuesta WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($id);
        return $this->conexion->ejecutarConsulta($sqlRespuestas, $tipos, $params);
    }

    // FIX: Cambiado el nombre a 'partidaFinalizada' para coincidir con el controlador
    public function partidaFinalizada($puntosPartida, $usuarioId){

        $sql = "INSERT INTO partida (usuarioId, puntos, fecha) VALUES (?, ?, ?)";
        $tipos = "sis"; // Asumiendo usuarioId es string, puntos es int, fecha es string
        $params = array($usuarioId, $puntosPartida, date("Y-m-d H:i:s", time()));
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

}