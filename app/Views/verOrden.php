<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalles de Orden | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary"> Detalles de la Orden</h3>
            <a href="<?= base_url('jefe-taller') ?>" class="btn btn-outline-secondary"> Volver</a>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold">Información de la Orden</h5>
            <hr>
            <p><strong>Código:</strong> <?= esc($orden['codigo_orden']) ?></p>
            <p><strong>Descripción:</strong> <?= esc($orden['descripcion']) ?></p>
            <p><strong>Tipo de Servicio:</strong> <?= esc($orden['tipo_servicio']) ?></p>
            <p><strong>Estado:</strong> <?= esc($orden['estado']) ?></p>
            <p><strong>Fecha de creación:</strong> <?= esc($orden['fecha_creacion']) ?></p>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold"> Técnico Asignado</h5>
            <hr>
            <p><?= esc($tecnico['nombre'] ?? 'Sin técnico asignado') ?></p>
        </div>

        <div class="card shadow-sm p-4 mb-4">
            <h5 class="fw-bold"> Cliente</h5>
            <hr>
            <?php if($cliente): ?>
            <p><strong>Tienda:</strong> <?= esc($cliente['nombre_tienda']) ?></p>
            <p><strong>Dirección:</strong> <?= esc($cliente['direccion']) ?></p>
            <p><strong>Teléfono:</strong> <?= esc($cliente['telefono']) ?></p>
            <?php else: ?>
            <p class="text-muted">No se encontró información del cliente.</p>
            <?php endif; ?>
        </div>

        <div class="card shadow-sm p-4">
            <h5 class="fw-bold"> Imágenes</h5>
            <hr>
            <?php if(!empty($imagenes)): ?>
            <div class="row">
                <?php foreach($imagenes as $img): ?>
                <div class="col-md-6 mb-3">
                    <img src="<?= base_url($img['ruta_imagen']) ?>" class="img-fluid rounded border shadow-sm">
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <p class="text-muted">No hay imágenes disponibles para esta orden.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>