<?php

class RolesModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "roles"; // Nombre de la tabla en la base de datos
    }
}
