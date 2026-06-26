<?php

class CategoriasController extends Controller {

    public function index($params = []) {
        $categorias = $this->model->all();
        $this->views->render("categorias/index", ["categorias" => $categorias]);
    }
}
