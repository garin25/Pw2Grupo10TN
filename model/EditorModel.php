<?php

class EditorModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarDatosUsuario($usuarioId)
    {

        $sql = "SELECT * FROM usuario WHERE usuarioid = ?";
        $tipos = "s";
        $params = array($usuarioId);

        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

    }

    public function traerPreguntas()
    {

        $sql = "SELECT 
    p.preguntaId,
    p.enunciado,
    c.nombre AS categoria,
    (p.respondidasMal / NULLIF(p.cantidadEnviada, 0)) AS ratio 
FROM 
    pregunta p 
JOIN 
    categoria c ON p.categoriaId = c.categoriaId
ORDER BY 
    p.categoriaId ASC";
        $tipos = "";
        $params = array();

        return $this->conexion->ejecutarConsultaSinParametros($sql);

    }

    public function eliminarPregunta($preguntaId){

        $tipos = "i";
        $params = [$preguntaId]; // Es el mismo para todas las consultas

        // 1. Borrar de la primera tabla "hijo"
        $sql_historial = "DELETE FROM historial_respuestas WHERE preguntaId = ?";
        $this->conexion->ejecutarConsulta($sql_historial, $tipos, $params);

        // 2. Borrar de la segunda tabla "hijo"
        $sql_evitar = "DELETE FROM preguntas_a_evitar WHERE preguntaId = ?";
        $this->conexion->ejecutarConsulta($sql_evitar, $tipos, $params);

        // 3. Borrar de la tercera tabla "hijo"
        $sql_respuestas = "DELETE FROM respuesta WHERE preguntaId = ?";
        $this->conexion->ejecutarConsulta($sql_respuestas, $tipos, $params);

        // 4. Finalmente, borrar la pregunta "padre"
        $sql_pregunta = "DELETE FROM pregunta WHERE preguntaId = ?";
        $this->conexion->ejecutarConsulta($sql_pregunta, $tipos, $params);
    }


    public function actualizarPreguntaYRespuestas(
        $preguntaId,
        $enunciado,
        $categoriaNombre,
        $respuestas,
        $idRespuestaCorrecta
    ) {

        $categoriaId = $this->obtenerIdDeCategoriaPorNombre($categoriaNombre);
        // Obtenemos la conexión directa para manejar la transacción
        $db = $this->conexion->getConexion();
        $db->begin_transaction();

        try {
            // 1. Actualizar la pregunta
            $sql_pregunta = "UPDATE pregunta SET enunciado = ?, categoriaId = ? WHERE preguntaId = ?";
            $this->conexion->ejecutarConsulta($sql_pregunta, "sii", [$enunciado, $categoriaId, $preguntaId]);

            // 2. Actualizar el texto de CADA respuesta
            foreach ($respuestas as $id => $data) {
                $texto = $data['texto'];
                $sql_respuesta = "UPDATE respuesta SET respuestaTexto = ? WHERE id_respuesta = ?";
                $this->conexion->ejecutarConsulta($sql_respuesta, "si", [$texto, $id]);
            }

            // 3a. Poner TODAS las respuestas de esta pregunta a 0
            $sql_reset = "UPDATE respuesta SET esCorrecta = 0 WHERE preguntaId = ?";
            $this->conexion->ejecutarConsulta($sql_reset, "i", [$preguntaId]);

            // 3b. Poner la respuesta ELEGIDA a 1
            $sql_set = "UPDATE respuesta SET esCorrecta = 1 WHERE id_respuesta = ?";
            $this->conexion->ejecutarConsulta($sql_set, "i", [$idRespuestaCorrecta]);

            // 4. Si todo salió bien, confirmamos los cambios
            $db->commit();
            return true;

        } catch (Exception $e) {
            // 5. Si algo falló, revertimos todo
            $db->rollback();
            return false;
        }
    }




    public function obtenerIdDeCategoriaPorNombre($nombreCategoria){
        $sql = "SELECT categoriaId FROM categoria WHERE nombre = ?";
        $tipos = "s";
        $params = array($nombreCategoria);

        $resultado = $this->conexion->ejecutarConsulta($sql, $tipos, $params);

        if (!empty($resultado)) {
            return $resultado[0]['categoriaId'];
        }
        return null;
    }


    public  function buscarPregunta($id)
    {
        $sqlRespuestas = "SELECT * FROM pregunta WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($id);
        return $this->conexion->ejecutarConsulta($sqlRespuestas, $tipos, $params);
    }

    public  function buscarRespuestas($id)
    {
        $sqlRespuestas = "SELECT * FROM respuesta WHERE preguntaId = ?";
        $tipos = "i";
        $params = array($id);
        return $this->conexion->ejecutarConsulta($sqlRespuestas, $tipos, $params);
    }

    public  function traerCategorias()
    {
        $sql = "SELECT nombre FROM categoria";
        return $this->conexion->ejecutarConsultaSinParametros($sql);
    }
}