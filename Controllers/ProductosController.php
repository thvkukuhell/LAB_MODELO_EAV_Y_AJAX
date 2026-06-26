<?php

class ProductosController extends Controller {

    public function apiGetFiltros($params = []) {
        $categoria_id = $params[0] ?? ($_GET['categoria_id'] ?? null);

        if ($categoria_id === null || !ctype_digit((string)$categoria_id)) {
            $this->jsonResponse([
                "error" => "categoria_id es requerido y debe ser nuelmerico"
            ], 400);
            return;
        }

        $categoria_id = (int)$categoria_id;

        try {
            $db = (new Conexion())->connect();

            $sqlCategoria = "SELECT COUNT(*) FROM categorias WHERE id = :categoria_id";
            $stmtCategoria = $db->prepare($sqlCategoria);
            $stmtCategoria->bindValue(":categoria_id", $categoria_id, PDO::PARAM_INT);
            $stmtCategoria->execute();

            if ((int)$stmtCategoria->fetchColumn() === 0) {
                $this->jsonResponse([
                    "error" => "La categoria no existe"
                ], 404);
                return;
            }

            $sql = "SELECT DISTINCT
                        a.id AS atributo_id,
                        a.nombre AS atributo,
                        vp.valor AS valor
                    FROM categorias c
                    INNER JOIN productos p ON p.categoria_id = c.id
                    INNER JOIN valores_productos vp ON vp.producto_id = p.id
                    INNER JOIN atributos a ON a.id = vp.atributo_id
                    WHERE c.id = :categoria_id
                    ORDER BY a.nombre ASC, vp.valor ASC";

            $stmt = $db->prepare($sql);
            $stmt->bindValue(":categoria_id", $categoria_id, PDO::PARAM_INT);
            $stmt->execute();

            $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $filtros = [];

            foreach ($filas as $fila) {
                $atributo_id = (int)$fila["atributo_id"];

                if (!isset($filtros[$atributo_id])) {
                    $filtros[$atributo_id] = [
                        "atributo_id" => $atributo_id,
                        "atributo" => $fila["atributo"],
                        "valores" => []
                    ];
                }

                $filtros[$atributo_id]["valores"][] = $fila["valor"];
            }

            $this->jsonResponse(array_values($filtros));
        } catch (PDOException $e) {
            $this->jsonResponse([
                "error" => "Error al obtener los filtros"
            ], 500);
        }
    }

    private function jsonResponse($data, $code = 200) {
        http_response_code($code);

        if (!headers_sent()) {
            header("Content-Type: application/json");
        }

        echo json_encode($data);
    }
}