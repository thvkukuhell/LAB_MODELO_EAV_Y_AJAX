<?php

class ProductosModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "productos";
    }

    /*
     FASE 4:
        Devuelve los atributos y valores únicos de una categoría.
        Va a Recorrer: productos -> valores_productos -> atributos
     */
    public function getFiltrosPorCategoria($categoria_id) {
        $categoria_id = (int) $categoria_id; 

        return $this->select("DISTINCT a.id AS atributo_id, a.nombre AS atributo, vp.valor")
                    ->join("valores_productos vp", "vp.id_producto = productos.id")
                    ->join("atributos a", "a.id = vp.id_atributo")
                    ->where(["productos.id_categoria = {$categoria_id}"])
                    ->orderBy("a.nombre, vp.valor")
                    ->get();
    }
}