<h2>Productos</h2>

<label for="buscarProducto">Buscar producto:</label>
<input type="text" id="buscarProducto" placeholder="Escribe el nombre del producto">

<table border="1" cellpadding="6" cellspacing="0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoria</th>
        </tr>
    </thead>
    <tbody id="productosTablaBody">
        <?php if (empty($data["productos"])): ?>
            <tr>
                <td colspan="3">No se encontraron productos.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($data["productos"] as $producto): ?>
                <tr>
                    <td><?= htmlspecialchars($producto["id"]); ?></td>
                    <td><?= htmlspecialchars($producto["nombre"]); ?></td>
                    <td><?= htmlspecialchars($producto["categoria"] ?? "Sin categoria"); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
    const PRODUCTOS_BUSCAR_URL = "<?= BASE_URL ?>productos/buscar";
</script>
<script src="<?= BASE_URL ?>Assets/js/productos_busqueda.js"></script>
