<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Dirección General | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/duenaStyle.css') ?>">
</head>


<body>
    <div class="d-flex" id="wrapper">

        <div class="sidebar">
            <div class="sidebar-header text-center py-3">
                <h4 class="fw-bold mb-0">Empresa <span class="text-accent">Aurora</span></h4>
            </div>
            <ul class="nav flex-column mt-4 px-3">
                <li class="nav-item mb-2"><a href="#panel" class="nav-link active"> Panel General</a></li>
                <li class="nav-item mb-2"><a href="#ordenes" class="nav-link"> Órdenes</a></li>
                <li class="nav-item mb-2"><a href="#departamentos" class="nav-link"> Departamentos</a></li>
                <li class="nav-item mb-2"><a href="#estadisticas" class="nav-link"> Estadísticas</a></li>
                <li class="nav-item mb-2"><a href="#reportes" class="nav-link"> Reportes</a></li>
                <li class="nav-item mb-2"><a href="#usuarios" class="nav-link"> Usuarios</a></li>
            </ul>
            <div class="mt-auto p-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light w-100">Cerrar sesión</a>
            </div>
        </div>
        <div class="overlay" id="overlay"></div>

        <div class="main-content flex-grow-1">
            <nav
                class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 d-flex justify-content-between align-items-center">
                <button class="toggle-sidebar" id="toggleSidebar">☰</button>
                <h4 class="text-primary mb-0">Panel de Dirección General</h4>
                <?php $session = session(); ?>
                <span class="fw-semibold text-muted">
                    Bienvenida, <span class="text-dark"><?= esc($session->get('nombre')) ?></span>
                </span>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('contacto') ?>">
                        <i class="bi bi-envelope"></i> Contacto
                    </a>
                </li>

            </nav>

            <div class="container-fluid mt-4">

                <section id="panel" class="mb-5">
                    <h5 class="fw-bold mb-3"> Resumen Global</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Órdenes Activas</h6>
                                <h3 class="fw-bold text-primary"><?= esc($ordenesActivas) ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Órdenes Completadas</h6>
                                <h3 class="fw-bold text-success"><?= esc($ordenesCompletadas) ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Empleados Totales</h6>
                                <h3 class="fw-bold text-info"><?= esc($empleadosTotales) ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Departamentos</h6>
                                <h3 class="fw-bold text-dark"><?= count($departamentos) ?></h3>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <section id="ordenes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Órdenes Recientes</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>ID</th>
                                    <th>Tienda</th>
                                    <th>Técnico</th>
                                    <th>Estado</th>
                                    <th>Jefe Asignado</th>
                                    <th>Fecha</th>
                                    <th>Detalles</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ordenes as $orden): ?>
                                <tr>
                                    <td><?= esc($orden['codigo_orden']) ?></td>
                                    <td>
                                        <?php
                                            $cliente = array_filter($clientes, fn($c) => $c['id_cliente'] == $orden['id_cliente']);
                                            $cliente = array_shift($cliente);
                                            echo esc($cliente['nombre_tienda'] ?? 'Desconocida');
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $tec = array_filter($usuarios, fn($u) => $u['id_usuario'] == $orden['id_tecnico']);
                                            $tec = array_shift($tec);
                                            echo $tec ? esc($tec['nombre']) : 'Sin asignar';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $estadoClase = match($orden['estado']) {
                                                'Pendiente' => 'bg-warning text-dark',
                                                'En proceso' => 'bg-info text-dark',
                                                'Completado' => 'bg-success',
                                                'Revisado', 'Aprobado' => 'bg-primary',
                                                default => 'bg-secondary'
                                            };
                                        ?>
                                        <span class="badge <?= $estadoClase ?>"><?= esc($orden['estado']) ?></span>
                                    </td>
                                    <td><?= esc($orden['jefe_asignado'] ?? '--') ?></td>
                                    <td><?= esc(date('Y-m-d', strtotime($orden['fecha_creacion']))) ?></td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm ver-detalle"
                                            data-id="<?= $orden['id_orden'] ?>"
                                            data-tienda="<?= esc($cliente['nombre_tienda'] ?? 'Desconocida') ?>"
                                            data-tecnico="<?= esc($tec['nombre'] ?? 'Sin asignar') ?>"
                                            data-estado="<?= esc($orden['estado']) ?>"
                                            data-jefe="<?= esc($orden['jefe_asignado'] ?? '--') ?>"
                                            data-fecha="<?= esc($orden['fecha_creacion']) ?>"
                                            data-observaciones="<?= esc($orden['observaciones'] ?? 'Sin observaciones') ?>">
                                            Ver
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <hr>

                <section id="departamentos" class="mb-5">
                    <h5 class="fw-bold mb-3">👥 Estado de los Departamentos</h5>
                    <div class="row g-3">
                        <?php foreach ($departamentos as $nombre => $count): ?>
                        <div class="col-md-3">
                            <div class="card dept-card shadow-sm p-3 text-center">
                                <h6><?= esc($nombre) ?></h6>
                                <p class="text-muted mb-1"><?= esc($count) ?> miembros activos</p>
                                <?php
$rolKey = match($nombre) {
    'Taller' => 'tecnico',
    'Ventas' => 'vendedor',
    'Gerencia' => 'gerente',
    'Contabilidad' => 'jefe_ventas',
    default => ''
};
?>
                                <a href="<?= base_url('duenia/departamento/'.$rolKey) ?>"
                                    class="btn btn-outline-primary btn-sm">Ver más</a>

                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <hr>

                <section id="estadisticas" class="mb-5">
                    <h5 class="fw-bold mb-3"> Estadísticas de Rendimiento</h5>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm p-3">
                                <h6 class="text-center fw-bold mb-3">Órdenes Completadas por Técnico</h6>
                                <canvas id="graficoTecnicos"></canvas>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm p-3">
                                <h6 class="text-center fw-bold mb-3">Órdenes Totales por Departamento</h6>
                                <canvas id="graficoDepartamentos"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <section id="reportes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Reportes Generales</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reportes as $r): ?>
                                <tr>
                                    <td><?= esc(date('Y-m-d H:i', strtotime($r['fecha']))) ?></td>
                                    <td><?= esc($r['usuario']) ?></td>
                                    <td><?= esc($r['rol']) ?></td>
                                    <td><?= esc($r['accion']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <hr>

                <section id="usuarios" class="mb-5">
                    <h5 class="fw-bold mb-3"> Administración de Usuarios</h5>
                    <div class="card shadow-sm p-4">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="fw-bold">Usuarios Registrados</h6>

                        </div>
                        <table class="table table-hover align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $u): ?>
                                <tr>
                                    <td><?= esc($u['id_usuario']) ?></td>
                                    <td><?= esc($u['nombre']) ?></td>
                                    <td>
                                        <?php
                                            $dept = match($u['rol']) {
                                                'tecnico' => 'Taller',
                                                'vendedor' => 'Ventas',
                                                'gerente' => 'Gerencia',
                                                'jefe_ventas' => 'Contabilidad',
                                                default => 'Otro'
                                            };
                                            echo esc($dept);
                                        ?>
                                    </td>
                                    <td><?= esc($u['rol']) ?></td>
                                    <td>
                                        <span class="badge <?= $u['estado'] ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $u['estado'] ? 'Activo' : 'Inactivo' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('duenia/usuario/' . $u['id_usuario'] . '/editar') ?>"
                                            class="btn btn-outline-secondary btn-sm">Editar</a>
                                        <?php if($u['estado']): ?>
                                        <a href="<?= base_url('duenia/usuario/' . $u['id_usuario'] . '/toggle') ?>"
                                            class="btn btn-outline-danger btn-sm">Desactivar</a>
                                        <?php else: ?>
                                        <a href="<?= base_url('duenia/usuario/' . $u['id_usuario'] . '/toggle') ?>"
                                            class="btn btn-outline-success btn-sm">Activar</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Detalles de la Orden</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ID:</strong> <span id="detalle-id"></span></p>
                    <p><strong>Tienda:</strong> <span id="detalle-tienda"></span></p>
                    <p><strong>Técnico:</strong> <span id="detalle-tecnico"></span></p>
                    <p><strong>Estado:</strong> <span id="detalle-estado"></span></p>
                    <p><strong>Jefe Asignado:</strong> <span id="detalle-jefe"></span></p>
                    <p><strong>Fecha:</strong> <span id="detalle-fecha"></span></p>
                    <p><strong>Observaciones:</strong></p>
                    <p id="detalle-observaciones" class="border p-2 bg-light rounded"></p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.querySelectorAll('.ver-detalle').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('detalle-id').innerText = btn.dataset.id;
            document.getElementById('detalle-tienda').innerText = btn.dataset.tienda;
            document.getElementById('detalle-tecnico').innerText = btn.dataset.tecnico;
            document.getElementById('detalle-estado').innerText = btn.dataset.estado;
            document.getElementById('detalle-jefe').innerText = btn.dataset.jefe;
            document.getElementById('detalle-fecha').innerText = btn.dataset.fecha;
            document.getElementById('detalle-observaciones').innerText = btn.dataset.observaciones;
            new bootstrap.Modal(document.getElementById('detalleModal')).show();
        });
    });

    const tecnicos = <?= json_encode(array_column($rendimientoTecnicos, 'nombre')) ?>;
    const ordenesTecnicos = <?= json_encode(array_column($rendimientoTecnicos, 'total')) ?>;
    const departamentos = <?= json_encode(array_keys($ordenesPorDept)) ?>;
    const ordenesDept = <?= json_encode(array_values($ordenesPorDept)) ?>;

    new Chart(document.getElementById('graficoTecnicos'), {
        type: 'bar',
        data: {
            labels: tecnicos,
            datasets: [{
                data: ordenesTecnicos,
                backgroundColor: 'rgba(54,162,235,0.7)'
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    new Chart(document.getElementById('graficoDepartamentos'), {
        type: 'pie',
        data: {
            labels: departamentos,
            datasets: [{
                data: ordenesDept,
                backgroundColor: ['#36A2EB', '#FF6384', '#FFCE56', '#4BC0C0']
            }]
        }
    });

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
</body>

</html>