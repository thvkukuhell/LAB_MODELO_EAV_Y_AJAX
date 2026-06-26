<?php

class VentasController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        // Verificar que haya sesión activa
        if (empty($_SESSION['usuario'])) {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        parent::__construct();
    }

    // Helper: verifica si el usuario tiene un permiso específico
    private function tienePermiso($clave) {
        return in_array($clave, $_SESSION['permisos'] ?? []);
    }

    public function index($params = []) {
        if (!$this->tienePermiso('listar_venta')) {
            $this->vistaDenegado(); return;
        }
        $ventas = $this->model->all();
        $this->views->render("ventas/index", ["ventas" => $ventas]);
    }

    public function crear($params = []) {
        if (!$this->tienePermiso('crear_venta')) {
            $this->vistaDenegado(); return;
        }
        $this->views->render("ventas/crear");
    }

    public function eliminar($params = []) {
        if (!$this->tienePermiso('eliminar_venta')) {
            $this->vistaDenegado(); return;
        }
        $this->model->delete($params[0]);
        header("Location: " . BASE_URL . "ventas");
        exit;
    }

    // Muestra vista de acceso denegado (403)
    private function vistaDenegado() {
        http_response_code(403);
        $this->views->render("error/denegado");
    }
}