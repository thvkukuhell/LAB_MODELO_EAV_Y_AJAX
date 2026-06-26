<?php

class ProductosModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "productos";
    }

    public function allWithCategoria() {
        $sql = "SELECT p.id, p.nombre, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id = p.id_categoria
                ORDER BY p.id DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorNombre($q) {
        $sql = "SELECT p.id, p.nombre, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id = p.id_categoria
                WHERE p.nombre LIKE :q
                ORDER BY p.id DESC";

        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":q", "%" . $q . "%", PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
