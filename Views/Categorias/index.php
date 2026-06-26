<h2>Categorias</h2>

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($data["categorias"])): ?>
            <tr>
                <td colspan="2">No se encontraron categorias.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data["categorias"] as $categoria): ?>
                <tr>
                    <td><?= htmlspecialchars($categoria["id"]); ?></td>
                    <td><?= htmlspecialchars($categoria["nombre"]); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
