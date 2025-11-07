<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Jefe de Ventas | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/jefeVentas.css') ?>">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="sidebar">
            <div class="sidebar-header text-center py-3">
                <h4 class="fw-bold mb-0">Empresa <span class="text-accent">Aurora</span></h4>
            </div>
            <ul class="nav flex-column mt-4 px-3">
                <li class="nav-item mb-2"><a href="#dashboard" class="nav-link active"> Dashboard</a></li>
                <li class="nav-item mb-2"><a href="#vendedores" class="nav-link"> Vendedores</a></li>
            </ul>
            <div class="mt-auto p-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light w-100">Cerrar sesión</a>
            </div>
        </div>
        <div class="overlay" id="overlay"></div>

        <div class="main-content flex-grow-1">
            <?php $session = session(); ?>
            <nav
                class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 d-flex justify-content-between align-items-center">
                <button class="toggle-sidebar" id="toggleSidebar">☰</button>
                <h4 class="text-primary mb-0">Panel del Jefe de Ventas</h4>
                <span class="fw-semibold text-muted">Bienvenido, <span
                        class="text-dark"><?= esc($session->get('nombre')) ?></span></span>
            </nav>

            <div class="container-fluid mt-4">

                <section id="dashboard" class="mb-5">
                    <h5 class="fw-bold mb-3"> Rendimiento del Departamento</h5>
                    <div class="row g-4">
                        <div class="col-md-8">
                            <div class="card shadow-sm p-3">
                                <h6 class="fw-semibold mb-3">Ventas Mensuales</h6>
                                <canvas id="graficoVentas"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card shadow-sm p-3">
                                <h6 class="fw-semibold mb-3">Progreso Semanal</h6>
                                <canvas id="graficoProgreso"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="vendedores" class="mb-5">
                    <h5 class="fw-bold mb-3"> Lista de Vendedores</h5>
                    <div class="table-responsive shadow-sm bg-white p-3 rounded-3">
                        <table class="table table-hover align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Clientes Atendidos</th>
                                    <th>Ventas</th>
                                    <th>Monto Total</th>
                                    <th>Desempeño</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($vendedores)): ?>
                                <?php foreach($vendedores as $v): ?>
                                <tr>
                                    <td><?= esc($v['nombre']) ?></td>
                                    <td><?= esc($v['clientes']) ?></td>
                                    <td><?= esc($v['ventas']) ?></td>
                                    <td>Q<?= number_format($v['monto'], 2) ?></td>
                                    <td>
                                        <?php
                          $color = match($v['desempeno']){
                              'Excelente' => 'success',
                              'Bueno' => 'warning text-dark',
                              'Bajo' => 'danger'
                          };
                        ?>
                                        <span class="badge bg-<?= $color ?>"><?= esc($v['desempeno']) ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">No hay vendedores registrados.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    const ventasMensuales = <?= json_encode($ventasMensuales) ?>;
    const ctx1 = document.getElementById('graficoVentas').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago'],
            datasets: [{
                label: 'Ventas Q',
                data: ventasMensuales,
                backgroundColor: '#082347'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const progresoSemanal = <?= json_encode($progresoSemanal) ?>;
    const ctx2 = document.getElementById('graficoProgreso').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Cumplido', 'Pendiente'],
            datasets: [{
                data: progresoSemanal,
                backgroundColor: ['#6c0c1a', '#d3d3d3']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
    </script>
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