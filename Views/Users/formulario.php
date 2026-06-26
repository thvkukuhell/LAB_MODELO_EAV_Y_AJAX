<h2>Crear Usuario</h2>

<form action="<?= BASE_URL ?>users/guardar" method="POST">
    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="nombre" required><br><br>

    <label for="correo">Correo:</label>
    <input type="email" id="correo" name="correo" required><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Crear Usuario">
</form>
