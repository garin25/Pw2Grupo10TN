<?php

class JuegoController
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
        $this->juego();
    }

    public function juego()
    {
        $data = ["page" => "Preguntas"];
        $this->renderer->render("juego", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}
