<?php

class LobbyController
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
        $this->lobby();
    }

    public function lobby()
    {
        $data = ["page" => "Lobby",  "logout" => "/login/logout"];

        $this->renderer->render("lobby", $data);
    }

    public function redirectToIndex()
    {
        header("Location: /");
        exit;
    }

}