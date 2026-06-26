<?php

class ClientesController extends Controller {

    public function index($params = []) {
        $clientes = [];
        $this->views->render("clientes/index", ["clientes" => $clientes]);
    }
}
