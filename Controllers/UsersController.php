<?php

class UsersController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (empty($_SESSION['usuario'])) {
            header("Location: " . BASE_URL . "login");
            exit;
        }

        parent::__construct();
    }

    public function index($params = []) {
        $this->listar();
    }
    
    

    public function listar($params = []) {
        $data = $this->model->where(["estado=1"])
                            ->orderBy("usuarios.id", "DESC")
                            ->get();

        $this->views->render("users/listado_async", $data);
    }

    public function cargarUsuariosAsync() {
        $data = $this->model->where(["estado=1"])
                            ->orderBy("usuarios.id", "DESC")
                            ->get();

        header("Content-Type: application/json");
        echo json_encode($data);
    }

    public function crear($params = []) {
        $this->views->render("users/formulario");
    }

    public function guardar($params = []) {
        $data = [
            "nombre" => $_POST['nombre'] ?? '',
            "correo" => $_POST['correo'] ?? '',
            "clave" => password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT),
            "estado" => 1
        ];

        if ($this->model->insert($data)) {
            header("Location: " . BASE_URL . "users");
            exit;
        }

        echo "Error al crear el usuario.";
    }
}
