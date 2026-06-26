<!-- Sin layout: la página de login no debe mostrar navbar -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); width: 320px; }
        h2 { color: #2c3e50; text-align: center; margin-bottom: 24px; }
        label { display: block; margin-bottom: 6px; color: #555; font-size: 14px; }
        input { width: 100%; padding: 10px; margin-bottom: 16px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-size: 14px; }
        button { width: 100%; padding: 12px; background: #2c3e50; color: white; border: none; border-radius: 4px; font-size: 15px; cursor: pointer; }
        button:hover { background: #34495e; }
        .error { background: #fdecea; color: #c0392b; padding: 10px; border-radius: 4px; margin-bottom: 16px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Iniciar Sesión</h2>

        <?php if (!empty($data['error'])): ?>
            <div class="error"><?= htmlspecialchars($data['error']); ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL; ?>login/autenticar" method="POST">
            <label>Correo electrónico</label>
            <input type="email" name="correo" required placeholder="correo@ejemplo.com">

            <label>Contraseña</label>
            <input type="password" name="clave" required placeholder="••••••••">

            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>