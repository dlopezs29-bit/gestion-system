<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles del Técnico | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/duenaStyle.css') ?>">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary"> Detalles del Técnico</h3>
            <a href="<?= base_url('jefe-taller') ?>" class="btn btn-outline-secondary"> Volver</a>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold"><?= esc($tecnico['nombre']) ?></h5>
            <p><strong>Usuario:</strong> <?= esc($tecnico['usuario']) ?></p>
            <p><strong>Correo:</strong> <?= esc($tecnico['correo']) ?></p>
            <p><strong>Estado:</strong> <?= esc($tecnico['estado'] ?? 'Activo') ?></p>
        </div>

        <div class="card shadow-sm p-4">
            <h5 class="fw-bold mb-3"> Órdenes Asignadas</h5>
            <?php if(!empty($ordenes)): ?>
            <ul class="list-group">
                <?php foreach($ordenes as $o): ?>
                <li class="list-group-item d-flex justify-content-between">
                    <span><strong><?= esc($o['codigo_orden']) ?>:</strong> <?= esc($o['descripcion']) ?></span>
                    <a href="<?= base_url('jefe-taller/ver_orden/'.$o['id_orden']) ?>"
                        class="btn btn-outline-primary btn-sm">Ver</a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="text-muted mb-0">No tiene órdenes asignadas actualmente.</p>
            <?php endif; ?>
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