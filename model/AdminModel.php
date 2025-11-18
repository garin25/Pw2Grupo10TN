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
          return $this->generarGraficoVacio("grafico_sexo_");
        }
        $this->limpiarArchivosTemporales("grafico_sexo_");

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

    public function crearImagenGraficoSexo($datos) {
        if (empty($datos)) {
            return $this->generarGraficoVacio("grafico_nivel_");
        }
        $this->limpiarArchivosTemporales("grafico_nivel_");

        $data = [];
        $labels = [];

        foreach ($datos as $fila) {
            $data[] = $fila['cantidad_jugadores'];
            $label = $fila['sexo'] . ' (' . $fila['cantidad_jugadores'] . ')';
            $labels[] = $label;
        }

        // 2. Crear el objeto del gráfico
        $graph = new PieGraph(500, 350);
        $graph->title->Set('Sexo de los Jugadores');

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
        $nombreArchivo = 'grafico_sexo_' . $idUnico . '.png';

        // 7. Definir la ruta de guardado
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/temp/' . $nombreArchivo;

        // 8. Guardar el gráfico en el disco
        $graph->Stroke($rutaAbsoluta);

        // 9. Devolver la RUTA WEB para el <img>
        return '/imagenes/temp/' . $nombreArchivo;
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

    public function generarPdfDeSexo() {
        // 1. Obtener datos
        $datosSexo = $this->getDatosSexoJugadores();

        // 2. REUTILIZAR tu helper (devuelve la URL web)
        // $urlGrafico es, por ej: /imagenes/temp/grafico_nivel_65f8c.png
        $urlGrafico = $this->crearImagenGraficoSexo($datosSexo);

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
                    <h1>Reporte de Sexo</h1>
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

    /**
     * Función auxiliar para borrar archivos viejos de una carpeta.
     * * @param string $prefijoArchivo El inicio del nombre del archivo (ej: 'grafico_nivel_')
     * @param int $segundosVida Tiempo en segundos antes de considerar el archivo "viejo" (default: 30s)
     */
    public function limpiarArchivosTemporales($prefijoArchivo, $segundosVida = 30) {

        // 1. Definir la ruta base
        $carpetaTemp = $_SERVER['DOCUMENT_ROOT'] . '/imagenes/temp/';

        // 2. Crear el patrón de búsqueda (ej: .../grafico_nivel_*.png)
        $patron = $carpetaTemp . $prefijoArchivo . '*.png';

        // 3. Buscar archivos
        $archivosEncontrados = glob($patron);

        // 4. Iterar y borrar si son viejos
        foreach ($archivosEncontrados as $archivo) {
            if (is_file($archivo)) {
                $edadArchivo = time() - filemtime($archivo);

                if ($edadArchivo > $segundosVida) {
                    @unlink($archivo); // Borrado silencioso
                }
            }
        }
    }

    /**
     * Genera una imagen con un mensaje de texto (usada cuando no hay datos).
     * * @param string $prefijoArchivo El prefijo para el nombre (ej: 'grafico_nivel_')
     * @param string $mensaje El texto a mostrar (default: "No hay datos")
     * @return string La URL web de la imagen generada.
     */
    private function generarGraficoVacio($prefijoArchivo, $mensaje = "No hay datos para mostrar") {

        // 1. Crear lienzo en blanco
        $graph = new Graph(500, 350);
        $graph->SetMargin(0,0,0,0);

        // 2. Configurar el título (el mensaje)
        $graph->title->Set($mensaje);
        $graph->title->SetFont(FF_FONT2, FS_BOLD, 14);
        $graph->title->SetMargin(150); // Ajustar según necesidad para centrar verticalmente

        // 3. Generar nombre único (Vital para evitar caché)
        $nombreArchivo = $prefijoArchivo . 'vacio_' . uniqid() . '.png';

        // 4. Definir rutas
        $rutaWeb = '/imagenes/temp/' . $nombreArchivo;
        $rutaAbsoluta = $_SERVER['DOCUMENT_ROOT'] . $rutaWeb;

        // 5. Guardar
        $graph->Stroke($rutaAbsoluta);

        // 6. Devolver la URL para la vista
        return $rutaWeb;
    }
}