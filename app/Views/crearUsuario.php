<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario | Gerencia General</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/duenaStyle.css') ?>">
</head>

<body>

    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-3 text-primary"> Crear Nuevo Usuario</h4>

            <form action="<?= base_url('gerente-general/usuarios/guardar') ?>" method="post">

                <div class="mb-3">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="usuario" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo electrónico</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select" required>
                        <option value="">Seleccione un rol</option>
                        <option value="duenia">Dueña</option>
                        <option value="gerente">Gerente General</option>
                        <option value="jefe_taller">Jefe de Taller</option>
                        <option value="tecnico">Técnico</option>
                        <option value="jefe_ventas">Jefe de Ventas</option>
                        <option value="vendedor">Vendedor</option>
                    </select>
                </div>

                <div class="text-end">
                    <a href="<?= base_url('gerente-general/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar Usuario</button>
                </div>

            </form>
        </div>
    </div>

</body>
<script>
const toggleBtn = document.getElementById('toggleSidebar');
const sidebar = document.querySelector('.sidebar');
const overlay = document.getElementById('overlay');

toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('active');
});

overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('active');
});
</script>

</html>