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

        $sql = "SELECT preguntaId FROM preguntas_a_evitar WHERE usuarioid = ?";
        $tipos = "s";
        $params = array($usuarioId);

        // FIX: Validar que la consulta devuelva un resultado
        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);
        if (is_array($resultado) && count($resultado) > 0) {
            return $resultado;
        }
        return [];

    }

    public function agregarIdsAEvitar($usuarioId, $preguntaId){

        $sql = "INSERT INTO preguntas_a_evitar (usuarioId, preguntaId) VALUES (?, ?)";
        $tipos = "ii";
        $params = array($usuarioId, $preguntaId);
        $this->conexion->ejecutarConsulta($sql, $tipos, $params);

    }

    public function buscarPregunta($categoria, $dificultad, $idsVistos = []){

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
        if (!empty($idsVistos)) {
            // 1. Crea un string de placeholders: "?,?,?"
            $placeholders = implode(',', array_fill(0, count($idsVistos), '?'));

            // 2. Añadimos la cláusula SQL
            $clausulaExclusion = " AND p.preguntaId NOT IN ($placeholders)";

            // 3. Añadimos los IDs al array de parámetros
            foreach ($idsVistos as $id) {
                $params[] = $id;
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
                    ORDER BY RAND()
                    LIMIT 1";

        $resultadoFallback = $this->conexion->ejecutarConsulta($sqlFallback, $tipos, $params);

        if (is_array($resultadoFallback) && count($resultadoFallback) > 0) {
            return $resultadoFallback[0];
        }

        // si ya no hay disponible preguntas se podria agregar intento 3 en donde de haria un truncate
        // en la tabla preguntas_a_evitar donde la categoria sea igual a la categoria que se busca.

        // 5. Si ya no hay más preguntas, devolvemos null
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

}