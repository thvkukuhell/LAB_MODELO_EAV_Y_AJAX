<?php

class PermisosModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "permisos"; // Nombre de la tabla en la base de datos
    }
}
