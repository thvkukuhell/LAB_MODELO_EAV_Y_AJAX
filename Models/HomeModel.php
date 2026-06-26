<?php

class HomeModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "home"; // Nombre de la tabla en la base de datos
    }
}