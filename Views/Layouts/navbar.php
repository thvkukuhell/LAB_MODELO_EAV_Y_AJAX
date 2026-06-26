<nav style="background: #2c3e50; padding: 12px; font-family: Arial, sans-serif;">
    <ul style="display: flex; list-style: none; gap: 20px; margin: 0; padding: 0; align-items: center;">
        <li><a href="<?= BASE_URL; ?>" style="color: white; text-decoration: none; font-weight: bold;">Inicio</a></li>

        <?php
        if (isset($_SESSION['rol_id'])) {
            $rolId = (int)$_SESSION['rol_id'];

            $menuModel = new class extends Model {
                public function __construct() {
                    parent::__construct();
                    $this->table = "menus";
                }
            };

            $menusPermitidos = $menuModel
                ->select("menus.*")
                ->join("roles_menus rm", "rm.menu_id = menus.id")
                ->where(["rm.rol_id = $rolId"])
                ->get();

            foreach ($menusPermitidos as $menu): ?>
                <li>
                    <a href="<?= BASE_URL . ltrim($menu['url'], '/'); ?>"
                       style="color: #ecf0f1; text-decoration: none;">
                        <?= htmlspecialchars($menu['titulo']); ?>
                    </a>
                </li>
            <?php endforeach;
        }
        ?>

        <?php if (isset($_SESSION['usuario'])): ?>
            <li style="margin-left: auto; color: #bdc3c7; font-size: 14px;">
                Bienvenido: <strong style="color: #2ecc71;"><?= htmlspecialchars($_SESSION['usuario']['nombre']); ?></strong>
                <a href="<?= BASE_URL; ?>login/salir" style="color: #e74c3c; margin-left: 15px; text-decoration: none;">[Salir]</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>