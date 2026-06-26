<?php

class UsersModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->table = "usuarios"; // Nombre de la tabla en la base de datos

    }

    /* Obtiene las claves de acceso (permisos) de un usuario dado su ID */
    public function getPermisosDeUsuario($usuario_id) {
        $resultado = $this
            ->select("p.clave_acceso")
            ->join("usuarios_roles ur",  "ur.usuario_id = usuarios.id")
            ->join("roles r",            "r.id = ur.rol_id")
            ->join("roles_permisos rp",  "rp.rol_id = r.id")
            ->join("permisos p",         "p.id = rp.permiso_id")
            ->where(["usuarios.id = $usuario_id"])
            ->get();

        $this->resetQuery();

        // Devolver solo los valores como array plano
        return array_column($resultado, 'clave_acceso');

    }

    /* Obtiene el rol_id del usuario (útil para el navbar dinámico) */
    public function getRolId($usuario_id) {
        $resultado = $this
            ->select("ur.rol_id")
            ->join("usuarios_roles ur", "ur.usuario_id = usuarios.id")
            ->where(["usuarios.id = $usuario_id"])
            ->first();

        $this->resetQuery();

        return $resultado['rol_id'] ?? null;
    }
}