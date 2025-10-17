<?php
include_once("helper/MyConexion.php");
include_once("helper/IncludeFileRenderer.php");
include_once("helper/NewRouter.php");
include_once("controller/LoginController.php");
include_once("controller/RankingController.php");
include_once("controller/LobbyController.php");
include_once("controller/JuegoController.php");
include_once("controller/MiPerfilController.php");
include_once("model/LoginModel.php");
include_once("model/RankingModel.php");
include_once("model/LobbyModel.php");
include_once("model/JuegoModel.php");
include_once("model/MiPerfilModel.php");
include_once('vendor/mustache/src/Mustache/Autoloader.php');
include_once ("helper/MustacheRenderer.php");

class ConfigFactory
{
    private $config;
    private $objetos;

    private $conexion;
    private $renderer;

    public function __construct()
    {
        $this->config = parse_ini_file("config/config.ini");

        $this->conexion= new MyConexion(
            $this->config["server"],
            $this->config["user"],
            $this->config["pass"],
            $this->config["database"]
        );

        $this->renderer = new MustacheRenderer("vista");

        $this->objetos["router"] = new NewRouter($this, "LoginController", "base");

        $this->objetos["LoginController"] = new LoginController(new LoginModel($this->conexion), $this->renderer);

        $this->objetos["RankingController"] = new RankingController(new RankingModel($this->conexion), $this->renderer);

        $this->objetos["LobbyController"] = new LobbyController(new LobbyModel($this->conexion), $this->renderer);

        $this->objetos["JuegoController"] = new JuegoController(new JuegoModel($this->conexion), $this->renderer);

        $this->objetos["JuegoController"] = new MiPerfilController(new MiPerfilModel($this->conexion), $this->renderer);


    }

    public function get($objectName)
    {
        return $this->objetos[$objectName];
    }
}
