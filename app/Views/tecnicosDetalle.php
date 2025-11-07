<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Orden | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body style="font-family: 'Poppins', sans-serif;">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary"> Detalles de la Orden</h3>
            <a href="<?= base_url('tecnicos') ?>" class="btn btn-outline-secondary"> Volver</a>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold">Información de la Orden</h5>
            <hr>
            <p><strong>Código:</strong> <?= esc($orden['codigo_orden']) ?></p>
            <p><strong>Descripción:</strong> <?= esc($orden['descripcion']) ?></p>
            <p><strong>Fecha de Creación:</strong> <?= esc($orden['fecha_creacion']) ?></p>
            <p><strong>Estado:</strong>
                <?php
                    $estado = $orden['estado'];
                    $badgeClass = 'secondary';
                    if ($estado === 'en_progreso') $badgeClass = 'warning text-dark';
                    if ($estado === 'completada') $badgeClass = 'success';
                ?>
                <span class="badge bg-<?= $badgeClass ?>"><?= ucfirst($estado) ?></span>
            </p>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold"> Cliente</h5>
            <hr>
            <?php if ($cliente): ?>
            <p><strong>Nombre:</strong> <?= esc($cliente['nombre_tienda']) ?></p>
            <p><strong>Dirección:</strong> <?= esc($cliente['direccion']) ?></p>
            <p><strong>Teléfono:</strong> <?= esc($cliente['telefono']) ?></p>
            <p><strong>Correo:</strong> <?= esc($cliente['correo']) ?></p>
            <?php else: ?>
            <p class="text-muted">Cliente no disponible.</p>
            <?php endif; ?>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold">📸 Imágenes</h5>
            <hr>
            <div class="row">
                <?php if (!empty($imagenes)): ?>
                <?php foreach ($imagenes as $img): ?>
                <div class="col-md-6 mb-3 text-center">
                    <p class="fw-semibold"><?= ucfirst(str_replace('_', ' ', $img['tipo'])) ?></p>
                    <img src="<?= base_url($img['ruta_imagen']) ?>" class="img-fluid rounded shadow-sm"
                        alt="Imagen de la orden">
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-muted text-center">No hay imágenes registradas.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="text-end">
            <a href="<?= base_url('tecnicos/marcar_completa/'.$orden['id_orden']) ?>" class="btn btn-success"> Marcar
                como Completada</a>
        </div>
    </div>
</body>

</html>