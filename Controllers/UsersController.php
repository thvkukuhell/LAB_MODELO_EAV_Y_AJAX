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
                            ->orderBy("users.id", "DESC")
                            ->get();
        // $this->views->render($this, "listado", $data); // Cargar la view con PHP (sin Javascript)
        $this->views->render($this, "listado_async", $data); /* Cargar la view con Javascript (fetch)
                                                                para obtener los datos de forma asíncrona
                                                                desde el método cargarUsuariosAsync() */
    }

    public function cargarUsuariosAsync() {
        $data = $this->model->where(["estado=1"])
                            ->orderBy("users.id", "DESC")
                            ->get();
        $json_resp = json_encode($data);
        header("Content-Type: application/json");
        echo $json_resp;
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
