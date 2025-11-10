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

    public function ejecutarConsultaSinParametros($sql) {

        $resultado = $this->conexion->query($sql);

        if ($resultado === false) {
            return [];
        }

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        return [];
    }

    /**
     * Ejecuta una consulta de modificación (INSERT, UPDATE, DELETE).
     *
     * @param string $sql La consulta SQL.
     * @param string $tipos Los tipos de parámetros (ej: "sii").
     * @param array $params Los parámetros.
     * @return int|false El número de filas afectadas, o false si la ejecución falló.
     */
    public function ejecutarModificacion($sql, $tipos, $params) {

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param($tipos, ...$params);

        // execute() devuelve true si la ejecución fue exitosa, false si falló.
        $exito = $stmt->execute();

        if (!$exito) {
            // La consulta falló (ej. error de sintaxis, clave foránea)
            $stmt->close();
            return false;
        }

        // Si la ejecución fue exitosa, vemos cuántas filas se borraron.
        $filasAfectadas = $stmt->affected_rows;
        $stmt->close();

        // Esto te devolverá 1 si borró 1 fila, 0 si no encontró la fila
        // para borrar, etc. Es mucho más útil que un simple 'true'.
        return $filasAfectadas;
    }

}
