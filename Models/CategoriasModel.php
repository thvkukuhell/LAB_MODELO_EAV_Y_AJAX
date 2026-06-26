<?php

class CategoriasModel extends Model {
    public function __construct() {
        parent::__construct();
        $this->table = "categorias";
    }
}