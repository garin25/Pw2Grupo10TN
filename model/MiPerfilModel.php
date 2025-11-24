<?php

class MiPerfilModel
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

    public function obtenerEstadisticasDeJuego($usuarioId) {

        // --- 1. Puntuación Máxima ---
        $sqlMaximaPuntuacion = "SELECT MAX(puntos) AS puntuacion_maxima FROM partida WHERE usuarioId = ?";
        $maxPuntosResultado = $this->conexion->ejecutarConsulta($sqlMaximaPuntuacion, "i", [$usuarioId]);
        $maxPuntos = $maxPuntosResultado[0]['puntuacion_maxima'] ?? 0;

        // --- 2. Partidas Jugadas ---
        $sqlPartidasJugadas = "SELECT COUNT(id_partida) AS total_partidas_jugadas FROM partida WHERE usuarioId = ?";
        $totalPartidasResultado = $this->conexion->ejecutarConsulta($sqlPartidasJugadas, "i", [$usuarioId]);
        $totalPartidas = $totalPartidasResultado[0]['total_partidas_jugadas'] ?? 0;

        // --- 3. Respuestas Correctas Totales ---
        $sqlRespuestasCorrectas = "SELECT COUNT(id_historial) AS total_respuestas_correctas FROM historial_respuestas WHERE usuarioId = ? AND fue_correcta = 1";
        $totalRespuestasCorrectasResultado = $this->conexion->ejecutarConsulta($sqlRespuestasCorrectas, "i", [$usuarioId]);
        $totalRespuestasCorrectas = $totalRespuestasCorrectasResultado[0]['total_respuestas_correctas'] ?? 0;

        return [
            'puntuacion_maxima' => $maxPuntos,
            'total_partidas_jugadas' => $totalPartidas,
            'total_respuestas_correctas' => $totalRespuestasCorrectas,
        ];
    }

    public function actualizarDatosUsuario($usuarioId, $nombreUsuario, $urlFoto){

        $sql = "UPDATE usuario SET nombre_usuario = ?, foto_perfil = ? WHERE usuarioid = ?";
        $tipos = "ssi";
        $params = [$nombreUsuario, $urlFoto, $usuarioId];

        return $this->conexion->ejecutarModificacion($sql, $tipos, $params);

    }

    public function actualizarNombreUsuario($usuarioId, $nombreUsuario){

        $sql = "UPDATE usuario SET nombre_usuario = ? WHERE usuarioid = ?";
        $tipos = "si";
        $params = [$nombreUsuario, $usuarioId];

        return $this->conexion->ejecutarModificacion($sql, $tipos, $params);

    }
}