<?php

class AdminController
{
    private $model;
    private $renderer;

    public function __construct($model, $renderer)
    {
        $this->model = $model;
        $this->renderer = $renderer;
    }

    public function base()
    {
        $this->paginaGraficos();
    }

    public function paginaGraficos(){
        if (!isset($_SESSION['usuarioId']) || $_SESSION['id_rol'] != 3) {
            $this->redirectToIndex();
        }

        $usuarioId = $_SESSION['usuarioId'];
        $usuario = $this->model->buscarDatosUsuario($usuarioId);
        $nivelJugadores = $this->model->getNivelJugadores();
        $sexoJugadores = $this->model->getDatosSexoJugadores();

        $urlGraficoNivel = $this->model->crearImagenGraficoNivel($nivelJugadores);

        $data = ["page" => "graficos", "logout" => "/login/logout", "usuario" => $usuario ,"arrayNivel"=>$nivelJugadores
            , "arraySexo"=>$sexoJugadores ,'urlGraficoNivel' => $urlGraficoNivel];

        $this->renderer->render("graficos", $data);
    }
    public function descargarReporteNivel() {
        // 1. Llama a la función del modelo que genera el PDF
        // (Esta función es casi igual a la que hicimos antes,
        // pero SÓLO para el gráfico de nivel)
        $pdfString = $this->model->generarPdfDeNivel();

        if ($pdfString) {
            // 2. Envía el PDF al navegador
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="reporte_nivel.pdf"');
            echo $pdfString;
            exit;
        }
    }

    public function descargarReporteSexo() {
        // 1. Llama a la función del modelo que genera el PDF
        $pdfString = $this->model->generarPdfDeSexo();

        if ($pdfString) {
            // 2. Envía el PDF al navegador
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="reporte_sexo.pdf"');
            echo $pdfString;
            exit;
        }
    }
    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }
}