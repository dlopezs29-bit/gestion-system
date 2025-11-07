<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departamento - <?= esc($departamentoNombre) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        background-color: #f4f6f9;
        font-family: 'Poppins', sans-serif;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.15);
    }

    .titulo {
        font-weight: 600;
        color: #333;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .table th {
        background-color: #007bff;
        color: white;
    }

    .table-hover tbody tr:hover {
        background-color: #e8f0fe;
    }
    </style>
</head>

<body>

    <div class="container mt-4 mb-5">
        <div class="text-center mb-4">
            <h2 class="titulo">Departamento de <?= esc($departamentoNombre) ?></h2>
            <p class="text-muted">Resumen de empleados, órdenes y actividad reciente</p>
            <a href="<?= base_url('duenia') ?>" class="btn btn-outline-secondary">
                Regresar al Panel General
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h6 class="text-muted">Empleados</h6>
                    <h3 class="fw-bold"><?= esc($totalUsuarios) ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h6 class="text-muted">Órdenes Totales</h6>
                    <h3 class="fw-bold"><?= esc($totalOrdenes) ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h6 class="text-muted">Órdenes Completadas</h6>
                    <h3 class="fw-bold text-success"><?= esc($ordenesCompletadas) ?></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h6 class="text-muted">Órdenes Activas</h6>
                    <h3 class="fw-bold text-primary"><?= esc($ordenesActivas) ?></h3>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="titulo mb-3">Rendimiento de empleados</h5>
                <div class="chart-container">
                    <canvas id="chartRendimiento"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="titulo mb-3">Actividad Reciente</h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Usuario</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reportes)): ?>
                        <?php foreach ($reportes as $r): ?>
                        <tr>
                            <td><?= esc(date('Y-m-d H:i', strtotime($r['fecha']))) ?></td>
                            <td><?= esc($r['usuario']) ?></td>
                            <td><?= esc($r['accion']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted">No hay registros recientes</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    const ctx = document.getElementById('chartRendimiento');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($rendimiento, 'nombre')) ?>,
            datasets: [{
                label: 'Órdenes completadas',
                data: <?= json_encode(array_column($rendimiento, 'total')) ?>,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    </script>

</body>

</html>