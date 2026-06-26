<a href="<?= BASE_URL ?>/users/crear">Crear Usuario</a>

<table border="1">
    <thead>
        <tr>
            <td>ID</td>
            <td>Nombre</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?> </td>
                <td><?php echo $user['correo']; ?> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>