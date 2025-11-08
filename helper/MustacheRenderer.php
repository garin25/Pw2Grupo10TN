<?php

class MustacheRenderer{
    private $mustache;
    private $viewsFolder;

    public function __construct($partialsPathLoader){
        $this->mustache = new Mustache_Engine(
            array(
            'partials_loader' => new Mustache_Loader_FilesystemLoader( $partialsPathLoader )
        ));
        $this->viewsFolder = $partialsPathLoader;
    }

    public function render($contentFile , $data = array() ){
        echo  $this->generateHtml(  $this->viewsFolder . '/' . $contentFile . "Vista.mustache" , $data);
    }

    public function generateHtml($contentFile, $data = array()) {
        $viewsSinLayout = [
            "vista/loginVista.mustache",
            "vista/registrarseVista.mustache",
            "vista/activacionVista.mustache",
            "vista/resultadoActivacionVista.mustache"
        ];

        $usaLayout = !in_array($contentFile, $viewsSinLayout);

        $contentAsString = "";

        if ($usaLayout) {
            // Obtenemos el rol. Si no existe, usamos 1 (Jugador) como default.
            $rol = $_SESSION['id_rol'] ?? 1;

            $headerFile = "";

            switch ($rol) {
                case 2: // Editor
                    $headerFile = 'headerEditor.mustache';
                    break;
                case 3: // Admin
                    $headerFile = 'headerEditor.mustache'; // Despues habria que crearle un header al Admin
                    break;
                case 1: // Jugador
                default: // Cualquier otro caso (incluido el default 1)
                    $headerFile = 'header.mustache';
                    break;
            }

            $contentAsString = file_get_contents($this->viewsFolder . '/' . $headerFile);
        }

        $contentAsString .= file_get_contents($contentFile);

        if ($usaLayout) {
            $contentAsString .= file_get_contents($this->viewsFolder . '/footer.mustache');
        }

        return $this->mustache->render($contentAsString, $data);
    }
}