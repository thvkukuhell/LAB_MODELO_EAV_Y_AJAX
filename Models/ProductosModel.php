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

    public function filtrarProductos($categoria_id, $q, $filtros) {
        $sql = "SELECT DISTINCT 
                    p.id, 
                    p.nombre, 
                    c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id = p.id_categoria
                WHERE 1 = 1";

        $params = [];

        if ($categoria_id !== "") {
            $sql .= " AND p.id_categoria = :categoria_id";
            $params[":categoria_id"] = (int) $categoria_id;
        }

        if ($q !== "") {
            $sql .= " AND p.nombre LIKE :q";
            $params[":q"] = "%" . $q . "%";
        }

        $i = 0;

        foreach ($filtros as $atributo_id => $valor) {
            if ($valor === "") {
                continue;
            }

            $sql .= " AND EXISTS (
                        SELECT 1 
                        FROM valores_productos vp{$i}
                        WHERE vp{$i}.id_producto = p.id
                        AND vp{$i}.id_atributo = :atributo{$i}
                        AND vp{$i}.valor = :valor{$i}
                    )";

            $params[":atributo{$i}"] = (int) $atributo_id;
            $params[":valor{$i}"] = $valor;

            $i++;
        }

        $sql .= " ORDER BY p.id DESC";

        $stmt = $this->connect()->prepare($sql);

        foreach ($params as $key => $value) {
            if (str_contains($key, "categoria") || str_contains($key, "atributo")) {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value, PDO::PARAM_STR);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
