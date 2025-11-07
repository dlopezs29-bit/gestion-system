<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto | La Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <div class="container py-5">
        <h2 class="text-center mb-4 fw-bold text-primary">📩 Contáctanos</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success text-center">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('contacto/enviar') ?>" method="post" class="card shadow-sm p-4 mx-auto" style="max-width: 600px;">
            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label fw-semibold">Correo electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mensaje" class="form-label fw-semibold">Mensaje</label>
                <textarea name="mensaje" id="mensaje" rows="4" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-send"></i> Enviar mensaje
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="<?= base_url('duenia') ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Regresar
            </a>
        </div>
    </div>

</body>
</html>
