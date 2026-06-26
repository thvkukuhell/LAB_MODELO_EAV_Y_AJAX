<?php

class LoginController extends Controller {

    public function __construct() {
        $this->views = new Views();
        require_once "Models/UsersModel.php";
        $this->model = new UsersModel();
    }

    // Mostrar el formulario de login
    public function index($params = []) {
        // Si ya hay sesión activa, redirigir directo
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!empty($_SESSION['usuario'])) {
            header("Location: " . BASE_URL . "ventas");
            exit;
        }
        $this->views->render("login/index");
    }

    // Validar las credenciales de usuario
    public function autenticar($params = []) {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $correo = $_POST['correo'] ?? '';
        $clave   = $_POST['clave']   ?? '';

        // 1. Buscar usuario por correo
        $usuario = $this->model
            ->where(["correo = '$correo'", "estado = 1"])
            ->first();

        // 2. Verificar que existe y la clave es correcta
        if (!$usuario || !password_verify($clave, $usuario['clave'])) {
            $this->views->render("login/index", [
                "error" => "Correo o contraseña incorrectos."
            ]);
            return;
        }

        // 3. Obtener los permisos del usuario (claves de acceso)
        $permisos = $this->model->getPermisosDeUsuario($usuario['id']);

        // 4. Guardar en sesión
        $_SESSION['usuario']  = $usuario;
        $_SESSION['permisos'] = $permisos;
        $_SESSION['rol_id']   = $this->model->getRolId($usuario['id']);

        // 5. Redirigir al módulo principal
        header("Location: " . BASE_URL . "ventas");
        exit;
    }

    // Cerrar sesión
    public function salir($params = []) {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_destroy();
        header("Location: " . BASE_URL . "login");
        exit;
    }
}