<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Empresa Aurora</title>


    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="<?= base_url('css/loginStyle.css') ?>">
</head>

<body>
    <div class="container">
        <section>
            <form action="<?= base_url('login/auth') ?>" method="post">
                <h1>Bienvenido a <span style="color:#6c0c1a;">Aurora</span></h1>
                <h3>Por favor ingresa tus credenciales</h3>

                <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" placeholder="Nombre de usuario" required>

                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Contraseña" required>

                <button id="btn1" type="submit">Iniciar sesión</button>
            </form>
        </section>
        
    </div>

</body>

</html>