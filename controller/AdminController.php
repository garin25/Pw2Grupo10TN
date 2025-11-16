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
        $pdfString = $this->model->generarPdfDeNivel();

        if ($pdfString) {
            // Envía el PDF al navegador
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="reporte_nivel.pdf"');
            echo $pdfString;
            exit;
        }
    }

    public function descargarReporteSexo() {
        $pdfString = $this->model->generarPdfDeSexo();

        if ($pdfString) {
            // Envía el PDF al navegador
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