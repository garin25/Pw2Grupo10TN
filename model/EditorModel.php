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

    public function editarPregunta($preguntaId,$enunciado,$categoria){
        $categoriaId = $this->obtenerIdDeCategoriaPorNombre($categoria);
        $sql = "UPDATE pregunta SET"
            ." enunciado = ?,"
            ." categoriaId = ? WHERE preguntaid = ?";
        $tipos = "sii";
        $params = array($preguntaId,$enunciado,$categoriaId);

         $this->conexion->ejecutarConsulta($sql, $tipos, $params);

}

    public function obtenerIdDeCategoriaPorNombre($nombreCategoria){
        $sql = "SELECT categoriaId FROM categoria WHERE nombre = ?";
        $tipos = "s";
        $params = array($nombreCategoria);

        $this->conexion->ejecutarConsulta($sql, $tipos, $params);
    }

}