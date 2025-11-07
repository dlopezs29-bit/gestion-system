<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/errorStyle.css') ?>">
</head>

<body>
    <div class="error-container text-center d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="error-box p-5 rounded-4 shadow-lg bg-white">
            <h1 class="display-1 fw-bold text-accent">404</h1>
            <h3 class="fw-semibold text-primary">Página no encontrada</h3>
            <p class="text-muted mb-4">Lo sentimos, la página que intentas acceder no existe o no tienes permiso para
                verla.</p>
            <a href="<?= base_url('login') ?>" class="btn btn-accent">Volver al inicio</a>
        </div>
        <footer class="mt-5 text-muted small">
            <strong>Empresa Aurora</strong> &copy; 2025 - Todos los derechos reservados
        </footer>
    </div>
</body>

</html>