<h2>Productos</h2>

<label for="buscarProducto">Buscar producto:</label>
<input type="text" id="buscarProducto" placeholder="Escribe el nombre del producto">
<br><br>

<label for="categoriaFiltro">Seleccionar categoría:</label>
<select id="categoriaFiltro">
    <option value="">Seleccione una categoría</option>
    <option value="1">Ropa de Hombre</option>
    <option value="2">Teléfonos</option>
    <option value="3">Ropa de Mujer</option>
    <option value="4">Electrónicos</option>
    <option value="5">Accesorios</option>
    <option value="6">Hogar</option>
    <option value="7">Calzado</option>
</select>

<div id="filtrosDinamicos" style="margin-top: 15px; padding: 10px; border: 1px solid #ccc;"></div>

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
    const PRODUCTOS_FILTROS_URL = "<?= BASE_URL ?>productos/apiGetFiltros/";
    const PRODUCTOS_FILTRAR_URL = "<?= BASE_URL ?>productos/apiFiltrar";
</script>
<script src="<?= BASE_URL ?>Assets/js/productos_busqueda.js"></script>
