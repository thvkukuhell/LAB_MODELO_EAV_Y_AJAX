<?php

class HomeController extends Controller {
    public function index($params = []) {
        $this->views->render("home/index");
    }

    public function datos($params = []) {
        $arr = [
            "titulo" => "Parámetros recibidos",
            "subtitulo" => "Estos son los parámetros recibidos en el método datos",
            "params" => $params
        ];
        $this->views->render("home/datos", $arr);
    }
}
