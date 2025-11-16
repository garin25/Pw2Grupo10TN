<?php
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
require_once 'lib/jpgraph-4.4.2/src/jpgraph.php';
require_once 'lib/jpgraph-4.4.2/src/jpgraph_pie.php';

class AdminModel
{
    private $conexion;

    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarDatosUsuario($usuarioId)
    {

        $sql = "SELECT * FROM usuario WHERE usuarioid = ?";
        $tipos = "i";
        $params = array($usuarioId);

        return $this->conexion->ejecutarConsulta($sql, $tipos, $params)[0];

    }

    public function getNivelJugadores()
    {
        /*
        * 1. (Subconsulta) Calcula el "ratio de error" para CADA jugador.
        * - Usamos LEFT JOIN para incluir jugadores que nunca han respondido.
        * - El ratio es: (respuestas_totales - respuestas_correctas) / respuestas_totales
        * 2. (Consulta Principal) Usa CASE para asignar un "nivel" (Facil, Medio, Dificil)
        * a cada jugador basado en su ratio.
        * 3. (Consulta Principal) Agrupa por "nivel" y cuenta cuántos jugadores
        * hay en cada categoría.
        */
        $sql = "
        SELECT
            CASE 
                WHEN ratio_error < 0.33 THEN 'Facil'
                WHEN ratio_error BETWEEN 0.33 AND 0.66 THEN 'Medio'
                ELSE 'Dificil'
            END AS nivel,
            COUNT(usuarioid) AS cantidad_jugadores
        FROM (
            -- Subconsulta para obtener el ratio de error por cada usuario
            SELECT 
                u.usuarioid,
                IF(
                    COUNT(hr.preguntaId) = 0, 
                    0.5,  -- Ratio por defecto para jugadores sin respuestas (cae en 'Medio')
                    (COUNT(hr.preguntaId) - SUM(hr.fue_correcta)) / COUNT(hr.preguntaId)
                ) AS ratio_error
            FROM 
                usuario u
            LEFT JOIN 
                historial_respuestas hr ON u.usuarioid = hr.usuarioid
            GROUP BY 
                u.usuarioid
        ) AS subconsulta_ratios
        GROUP BY 
            nivel;";

        // Devuelve
        // [
        //   ['nivel' => 'Facil', 'cantidad_jugadores' => 10],
        //   ['nivel' => 'Medio', 'cantidad_jugadores' => 5],
        //   ['nivel' => 'Dificil', 'cantidad_jugadores' => 2]
        // ]
        return $this->conexion->ejecutarConsultaSinParametros($sql);
    }

    public function getDatosSexoJugadores()
    {
        $sql = "
        SELECT
            CASE 
                WHEN sexo = 'Femenino' THEN 'Femenino'
               WHEN sexo = 'Masculino' THEN 'Masculino'
                ELSE 'Prefiero no cargarlo'
            END AS sexo,
            COUNT(usuarioid) AS cantidad_jugadores
        FROM usuario
        GROUP BY sexo;";
        return $this->conexion->ejecutarConsultaSinParametros($sql);
        // Devuelve
        // [
        //   ['sexo' => 'Femenino', 'cantidad_jugadores' => 1],
        // ]
    }


    /**
     * Crea el gráfico de Nivel y lo guarda en /imagenes/temp/
     *
     * @param array $datos Los datos de la consulta (ej: [['nivel' => 'Facil', 'cantidad_jugadores' => 10], ...])
     * @return string La RUTA ABSOLUTA del servidor al archivo de imagen.
     */
    public function crearImagenGraficoNivel($datos) {

        // --- ¡LA SOLUCIÓN! ---
        // Si la consulta no devuelve datos (o es null), no podemos dibujar.
        if (empty($datos)) {
            // Creamos una imagen de "error" en su lugar
            $graph = new Graph(500, 350); // Un lienzo en blanco
            $graph->SetMargin(0,0,0,0); // Sin márgenes

            // Añadimos un título que sirva como mensaje de error
            $graph->title->Set("No hay datos para mostrar");
            $graph->title->SetFont(FF_FONT2, FS_BOLD, 14);
            $graph->title->SetMargin(150); // Centrarlo (aprox)

            // Definimos la ruta y "dibujamos" el lienzo en blanco con el texto
            $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/temp/grafico_nivel.png';
            $graph->Stroke($rutaAbsoluta);
            return $rutaAbsoluta;
        }
        // --- FIN DE LA SOLUCIÓN ---


        // 1. Preparar los datos (esto es el código que ya tenías)
        $data = [];
        $labels = [];

        foreach ($datos as $fila) {
            $data[] = $fila['cantidad_jugadores'];
            $label = $fila['nivel'] . ' (' . $fila['cantidad_jugadores'] . ')';
            $labels[] = $label;
        }

        // 2. Crear el objeto del gráfico
        $graph = new PieGraph(500, 350);
        $graph->title->Set('Nivel de Jugadores');

        // 3. Crear el "plot"
        $p1 = new PiePlot($data);

        // 4. Configurar las leyendas
        $p1->SetLegends($labels);

        // 5. (Opcional) Mostrar porcentajes
        $p1->SetLabelType(PIE_VALUE_PER);
        $p1->value->Show();
        $p1->value->SetFont(FF_FONT1, FS_BOLD);
        $p1->value->SetColor('black');

        // 6. Añadir el plot al gráfico
        $graph->Add($p1);

        $idUnico = uniqid();
        $nombreArchivo = 'grafico_nivel_' . $idUnico . '.png';

        // 7. Definir la ruta de guardado
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/temp/' . $nombreArchivo;

        // 8. Guardar el gráfico en el disco
        $graph->Stroke($rutaAbsoluta);

        // 9. Devolver la RUTA WEB para el <img>
        return '/imagenes/temp/' . $nombreArchivo;
    }

// Haz lo mismo para la función crearImagenGraficoSexo($datos)
    public function crearImagenGraficoSexo($datos) {
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/temp/grafico_sexo.png';
        // ... tu lógica de JPGraph para Sexo ...
        // $graph->Stroke($rutaAbsoluta);
        @copy($_SERVER['DOCUMENT_ROOT'] . '/imagenes/logo.jpg', $rutaAbsoluta);
        return $rutaAbsoluta;
    }

    public function generarPdfDeNivel() {
        // 1. Obtener datos
        $datosNivel = $this->getNivelJugadores();

        // 2. REUTILIZAR tu helper (devuelve la URL web)
        // $urlGrafico es, por ej: /imagenes/temp/grafico_nivel_65f8c.png
        $urlGrafico = $this->crearImagenGraficoNivel($datosNivel);

        // 3. Reconstruir la RUTA ABSOLUTA (para LEER el archivo)
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . $urlGrafico;

        // --- ¡ESTA ES LA SOLUCIÓN! ---

        // 4. Leer los datos binarios de la imagen que acabas de crear
        $imageData = file_get_contents($rutaAbsoluta);

        // 5. Codificar esos datos en Base64
        $imageBase64 = 'data:image/png;base64,' . base64_encode($imageData);

        // 6. Crear el HTML (usando la cadena Base64 en el src)
        $html = "<html>
                <head><style>body { font-family: sans-serif; }</style></head>
                <body>
                    <h1>Reporte de Nivel</h1>
                    <img src='". $imageBase64 ."' style='width: 100%;'>
                </body>
            </html>";

        // 7. Generar PDF (Dompdf)
        $dompdf = new Dompdf();
        // 'isRemoteEnabled' ya no es ni siquiera necesario, pero no hace daño
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadHtml($html);
        $dompdf->render();

        // 8. Guarda el PDF final en una variable
        $pdfOutputString = $dompdf->output();

        // 9. ¡Ahora sí, borra el archivo temporal!
        unlink($rutaAbsoluta);

        // 10. Devuelve el PDF
        return $pdfOutputString;
    }

}