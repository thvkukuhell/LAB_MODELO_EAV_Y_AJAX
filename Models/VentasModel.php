<?php

class VentasModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "ventas"; 
    }
}