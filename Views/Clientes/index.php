<h2>Clientes</h2>

<p>Listado basico de clientes.</p>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data["clientes"])): ?>
            <tr>
                <td colspan="2">No se encontraron clientes.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data["clientes"] as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente["id"]); ?></td>
                    <td><?= htmlspecialchars($cliente["nombre"]); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
