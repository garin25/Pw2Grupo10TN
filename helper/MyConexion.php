<?php

class MyConexion
{

    private $conexion;

    public function __construct($server, $user, $pass, $database)
    {
        $this->conexion = new mysqli($server, $user, $pass, $database);
        if ($this->conexion->error) { die("Error en la conexión: " . $this->conexion->error); }
    }

    public function getConexion()
    {
        return $this->conexion;
    }

    public function ejecutarConsulta($sql, $tipos, $params) {

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param($tipos, ...$params);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $stmt->close();

        if ($resultado && $resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        return null;
    }

}
