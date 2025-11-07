<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Gerente General | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/gerenteGeneralStyle.css') ?>">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="sidebar">
            <div class="sidebar-header text-center py-3">
                <h4 class="fw-bold mb-0">Empresa <span class="text-accent">Aurora</span></h4>
            </div>
            <ul class="nav flex-column mt-4 px-3">
                <li class="nav-item mb-2"><a href="#resumen" class="nav-link active"> Resumen General</a></li>
                <li class="nav-item mb-2"><a href="#ordenes" class="nav-link"> Órdenes de Trabajo</a></li>
                <li class="nav-item mb-2"><a href="#reportes" class="nav-link"> Reportes</a></li>
                <li class="nav-item mb-2"><a href="#comentarios" class="nav-link"> Observaciones</a></li>
                <li class="nav-item mt-3">
                    <a href="<?= base_url('gerente-general/usuarios') ?>" class="nav-link text-warning fw-semibold">
                        Gestión de Usuarios
                    </a>
                </li>
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
                <h4 class="text-primary mb-0">Panel de Gerencia General</h4>
                <span class="fw-semibold text-muted">
                    Bienvenida, <span class="text-dark"><?= esc(session()->get('nombre')) ?></span>
                </span>
            </nav>

            <div class="container mt-4">

                <section id="resumen" class="mb-5">
                    <h5 class="fw-bold mb-3"> Resumen General de Actividad</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Órdenes Pendientes</h6>
                                <h3 class="fw-bold text-warning"><?= esc($resumen['pendientes'] ?? 0) ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Órdenes Completadas</h6>
                                <h3 class="fw-bold text-success"><?= esc($resumen['completadas'] ?? 0) ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Técnicos Activos</h6>
                                <h3 class="fw-bold text-info"><?= esc($resumen['tecnicos'] ?? 0) ?></h3>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card stat-card shadow-sm p-3 text-center">
                                <h6>Reportes Aprobados</h6>
                                <h3 class="fw-bold text-primary"><?= esc($resumen['reportes'] ?? 0) ?></h3>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <section id="ordenes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Órdenes Enviadas por Jefe de Taller</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>ID</th>
                                    <th>Tienda</th>
                                    <th>Técnico</th>
                                    <th>Descripción</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ordenes)): ?>
                                <?php foreach ($ordenes as $orden): ?>
                                <tr>
                                    <td><?= esc($orden['id']) ?></td>
                                    <td><?= esc($orden['tienda']) ?></td>
                                    <td><?= esc($orden['tecnico']) ?></td>
                                    <td><?= esc($orden['descripcion']) ?></td>
                                    <td><?= esc($orden['fecha']) ?></td>
                                    <td>
                                        <?php if ($orden['estado'] === 'Pendiente'): ?>
                                        <span class="badge bg-warning text-dark">Pendiente Aprobación</span>
                                        <?php elseif ($orden['estado'] === 'Aprobada'): ?>
                                        <span class="badge bg-success">Aprobada</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary"><?= esc($orden['estado']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm">Ver Detalles</button>
                                        <?php if ($orden['estado'] === 'Pendiente'): ?>
                                        <button class="btn btn-outline-success btn-sm">Aprobar</button>
                                        <button class="btn btn-outline-danger btn-sm">Rechazar</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No hay órdenes registradas</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <hr>

                <section id="reportes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Reportes Generales</h5>
                    <div class="card shadow-sm p-4">
                        <p class="mb-2">Filtros:</p>
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <select class="form-select">
                                    <option selected>Filtrar por técnico</option>
                                    <?php foreach ($tecnicos as $tec): ?>
                                    <option><?= esc($tec) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select">
                                    <option selected>Filtrar por departamento</option>
                                    <?php foreach ($departamentos as $dep): ?>
                                    <option><?= esc($dep) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-accent w-100">Generar Reporte</button>
                            </div>
                        </div>

                        <div class="alert alert-secondary small text-center mb-0">
                            Aquí se mostrará un gráfico o resumen generado.
                        </div>
                    </div>
                </section>

                <hr>

                <section id="comentarios" class="mb-5">
                    <h5 class="fw-bold mb-3"> Observaciones / Notas</h5>
                    <form class="shadow-sm p-4 bg-white rounded-3">
                        <label class="form-label">Enviar Observación a:</label>
                        <select class="form-select mb-3">
                            <option selected>Seleccionar destinatario</option>
                            <?php foreach ($destinatarios as $d): ?>
                            <option><?= esc($d) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label class="form-label">Mensaje</label>
                        <textarea class="form-control mb-3" rows="3"
                            placeholder="Escriba su observación o comentario..."></textarea>
                        <button type="submit" class="btn btn-accent">Enviar</button>
                    </form>
                </section>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
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