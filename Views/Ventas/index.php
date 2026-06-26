<div style="font-family: Arial, sans-serif; margin: 20px 0;">
    <h2 style="color: #2c3e50; border-bottom: 2px solid #ccc; padding-bottom: 8px;">Módulo de Ventas</h2>
    <p>Panel operativo del sistema.</p>

    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%; margin-top: 15px;">
        <thead style="background-color: #f4f4f4;">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Monto Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1001</td>
                <td>Ana María Gómez</td>
                <td>S/. 250.00</td>
                <td>
                    <a href="#" style="color: #3498db; text-decoration: none; margin-right: 15px;">[Ver]</a>

                    <?php 
                    // Si es Vendedor, no tiene 'eliminar_venta' en $_SESSION['permisos'], ocultando el botón
                    $misPermisos = $_SESSION['permisos'] ?? [];
                    if (in_array('eliminar_venta', $misPermisos)): 
                    ?>
                        <a href="#" style="color: #e74c3c; text-decoration: none; font-weight: bold;">[Eliminar]</a>
                    <?php endif; ?>
                </td>
            </tr>
        </tbody>
    </table>
</div>