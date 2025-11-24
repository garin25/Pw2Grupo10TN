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

    public function traerIdsAEvitar($usuarioId){

        $sql = "SELECT preguntaId FROM preguntas_a_evitar WHERE usuarioId = ?";
        $tipos = "i";
        $params = array($usuarioId);

        // FIX: Validar que la consulta devuelva un resultado
        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);
        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado;
        }
        return null;

    }

    public function agregarIdsAEvitar($usuarioId, $preguntaId){

        $sql = "INSERT INTO preguntas_a_evitar (usuarioId, preguntaId) VALUES (?, ?)";
        $tipos = "ii";
        $params = array($usuarioId, $preguntaId);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function buscarPregunta($categoria, $dificultad, $idsVistos, $usuarioId){

        // Usamos IF() de MySQL para evitar 100% la división por cero.
        $ratioSeguro = "IF(p.cantidadEnviada = 0, 0.5, (p.respondidasMal / p.cantidadEnviada))";

        $condicionDificultad = "";

        // 1. Definimos el filtro SQL
        if ($dificultad == "Facil") {
            $condicionDificultad = "AND ($ratioSeguro < 0.33)";
        } elseif ($dificultad == "Medio") {
            $condicionDificultad = "AND ($ratioSeguro BETWEEN 0.33 AND 0.66)";
        } elseif ($dificultad == "Dificil") {
            $condicionDificultad = "AND ($ratioSeguro > 0.66)";
        }

        // --- NUEVA LÓGICA PARA EXCLUIR EL ARRAY ---
        $params = [$categoria];
        $tipos = "s";
        $clausulaExclusion = "";

        // Si el array $idsVistos no está vacío, creamos la cláusula NOT IN
        if ($idsVistos != null) {
            // 1. Crea un string de placeholders: "?,?,?"
            $placeholders = implode(',', array_fill(0, count($idsVistos), '?'));

            // 2. Añadimos la cláusula SQL
            $clausulaExclusion = " AND p.preguntaId NOT IN ($placeholders)";

            // 3. Añadimos los IDs al array de parámetros
            foreach ($idsVistos as $id) {
                $params[] = $id['preguntaId'];
                $tipos .= "i"; // 'i' por cada ID entero
            }
        }
        // --- FIN DE LA NUEVA LÓGICA ---


        // 2. INTENTO 1: Buscar con dificultad específica y exclusión
        $sql = "SELECT * FROM pregunta p 
            JOIN categoria c ON c.categoriaId = p.categoriaId
            WHERE c.nombre = ? 
            $condicionDificultad
            $clausulaExclusion
            AND esSugerida = 0
            AND esReportada = 0
            ORDER BY RAND()
            LIMIT 1";

        // Nota: $tipos y $params ya están listos
        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado[0];
        }

        // 4. INTENTO 2 (FALLBACK): Buscar CUALQUIER pregunta no vista
        $sqlFallback = "SELECT * FROM pregunta p 
                    JOIN categoria c ON c.categoriaId = p.categoriaId
                    WHERE c.nombre = ? 
                    $clausulaExclusion
                    AND  esSugerida = 0
                    AND esReportada = 0
                    ORDER BY RAND()
                    LIMIT 1";

        $resultadoFallback = $this->conexion->ejecutarConsulta($sqlFallback, $tipos, $params);

        if (is_array($resultadoFallback) && count($resultadoFallback) > 0) {
            return $resultadoFallback[0];
        }

        // Se borra los registros de preguntas a evitar id de dicha categoria ya que las respondio todas.

        $sqlDeleteIdVistos = "DELETE pe FROM preguntas_a_evitar pe
                                JOIN pregunta p ON pe.preguntaId = p.preguntaId
                                JOIN categoria c ON c.categoriaId = p.categoriaId
                                WHERE c.nombre = ?
                                AND pe.usuarioId = ?";
        $tiposDeleteIdVistos = "si";
        $paramsDeleteIdVistos = array($categoria, $usuarioId);

        $this->conexion->ejecutarModificacion($sqlDeleteIdVistos, $tiposDeleteIdVistos, $paramsDeleteIdVistos);


        // INTENTO 3: Buscar con dificultad específica y exclusión con los id que ya fueron borrados
        $sql3 = "SELECT * FROM pregunta p 
            JOIN categoria c ON c.categoriaId = p.categoriaId
            WHERE c.nombre = ? 
            $condicionDificultad
            $clausulaExclusion
            AND esSugerida = 0
            AND esReportada = 0
            ORDER BY RAND()
            LIMIT 1";

        // Nota: $tipos y $params ya están listos
        $resultado = $this->conexion->ejecutarConsulta($sql3, $tipos, $params);

        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado[0];
        }

        return null;
    }

    public  function buscarRespuestas($id)
    {
        $sqlRespuestas = "SELECT * FROM respuesta 
                        WHERE preguntaId = ? 
                        ORDER BY RAND()";
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

    public function devolverPregunta($preguntaId){
        $sql = "SELECT * FROM pregunta 
            WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($preguntaId);
        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];
    }

    public function agregarRespuestaAlHistorial($preguntaId, $usuarioId, $fueCorrecta, $fecha){

        $sql = "INSERT INTO historial_respuestas (usuarioId, preguntaId, fue_correcta, fecha_respuesta) VALUES (?, ?, ?, ?)";
        $tipos = "iiis";
        $params = array($usuarioId, $preguntaId, $fueCorrecta, $fecha);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function aumentarCantidadEnviadaEnPregunta($preguntaId){

        $sql = "UPDATE pregunta SET cantidadEnviada = cantidadEnviada + 1 WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($preguntaId);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function aumentarRespondidasMalEnPregunta($preguntaId){

        $sql = "UPDATE pregunta SET respondidasMal = respondidasMal + 1 WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($preguntaId);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function reportarPregunta($preguntaId, $usuarioId, $descripcion){

        $sql = "INSERT INTO reportes (usuarioId, preguntaId, descripcion) VALUES (?, ?, ?)";
        $tipos = "iis";
        $params = array($usuarioId, $preguntaId, $descripcion);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function verCantidadDeReportesPorPregunta($preguntaId){

        $sql = "SELECT COUNT(*) as cantidadReportes FROM reportes WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($preguntaId);
        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

    }

    public function editarEstadoDeReporte($preguntaId){

        $sql = "UPDATE pregunta SET esReportada = ? WHERE preguntaId = ?";
        $tipos = "ii";
        $params = array(true, $preguntaId);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function enviarPreguntaSugerida($enunciado, $respuestas, $categoriaId, $respuestaCorrecta)
    {
        $db = $this->conexion->getConexion();
        $db->begin_transaction();

        try {

            $sql_pregunta = "INSERT INTO pregunta (enunciado, categoriaId, esSugerida) VALUES (?, ?, ?)";

            $this->conexion->ejecutarConsulta($sql_pregunta, "sii", [$enunciado, $categoriaId, 1]);


            $preguntaId = $db->insert_id;
            $i = 0;
            foreach ($respuestas as $respuesta) {

                $sql_respuesta = "INSERT INTO respuesta (respuestaTexto, esCorrecta, preguntaId) 
                              VALUES (?, ?, ?)";

                if ($i == $respuestaCorrecta){
                    $this->conexion->ejecutarConsulta($sql_respuesta, "sii", [$respuesta, 1, $preguntaId]);
                } else {
                    $this->conexion->ejecutarConsulta($sql_respuesta, "sii", [$respuesta, 0, $preguntaId]);
                }

                $i += 1;
            }

            $db->commit();
            return true;

        } catch (Exception $e) {
            $db->rollback();
            return false;
        }
    }

    public function traerCategoriasActivas()
    {
        // Trae todas las categorías de la tabla
        $sql = "SELECT * FROM categoria";

        // Usamos el método que no requiere parámetros
        return $this->conexion->ejecutarConsultaSinParametros($sql);
    }
}