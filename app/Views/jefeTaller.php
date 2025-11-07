<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Jefe de Taller | Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/jefeTaller.css') ?>">
</head>

<body>
    <div class="d-flex" id="wrapper">
        <div class="sidebar">
            <div class="sidebar-header text-center py-3">
                <h4 class="fw-bold mb-0">Aurora Taller</h4>
            </div>
            <ul class="nav flex-column mt-4 px-3">
                <li class="nav-item mb-2"><a href="#tecnicos" class="nav-link active"> Técnicos</a></li>
                <li class="nav-item mb-2"><a href="#ordenes" class="nav-link"> Órdenes</a></li>
                <li class="nav-item mb-2"><a href="#cronograma" class="nav-link"> Cronograma</a></li>
            </ul>
            <div class="mt-auto p-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light w-100">Cerrar sesión</a>
            </div>
        </div>
        <div class="overlay" id="overlay"></div>

        <div class="main-content flex-grow-1 p-4">
            <button class="toggle-sidebar" id="toggleSidebar">☰</button>
            <h3 class="mb-4">Panel del Jefe de Taller</h3>

            <section id="tecnicos" class="mb-5">
                <h5 class="fw-bold mb-3"> Técnicos</h5>
                <div class="row">
                    <?php foreach($tecnicos as $tec): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card tecnico-card text-center p-3">
                            <img src="<?= esc($tec['foto'] ?? base_url('img/imgW.png')) ?>"
                                alt="<?= esc($tec['nombre']) ?>" class="rounded-circle mb-2" width="100" height="100"
                                style="object-fit: cover;">
                            <h5 class="fw-bold"><?= esc($tec['nombre']) ?></h5>
                            <button class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal"
                                data-bs-target="#modalAsignarTrabajo" data-id="<?= $tec['id_usuario'] ?>"
                                data-nombre="<?= esc($tec['nombre']) ?>">
                                Asignar Trabajo
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <section id="ordenes" class="mb-5">
                <h5 class="fw-bold mb-3"> Órdenes Asignadas</h5>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-header">
                            <tr>
                                <th>Código</th>
                                <th>Técnico</th>
                                <th>Cliente</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($ordenes as $o): 
                                $tecnico = array_filter($tecnicos, fn($t) => $t['id_usuario']==$o['id_tecnico']);
                                $tecnico = reset($tecnico);
                                $cliente = array_filter($clientes, fn($c) => $c['id_cliente']==$o['id_cliente']);
                                $cliente = reset($cliente);
                            ?>
                            <tr>
                                <td><?= esc($o['codigo_orden']) ?></td>
                                <td><?= esc($tecnico['nombre'] ?? 'Sin técnico') ?></td>
                                <td><?= esc($cliente['nombre_tienda'] ?? 'Sin cliente') ?></td>
                                <td><?= esc($o['descripcion']) ?></td>
                                <td>
                                    <span
                                        class="badge bg-<?= $o['estado']=='Pendiente'?'warning text-dark':'success' ?>">
                                        <?= esc($o['estado']) ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="cronograma">
                <h5 class="fw-bold mb-3"> Cronograma Semanal</h5>

                <form method="get" class="mb-3 d-flex align-items-center">
                    <label class="me-2 fw-semibold">Seleccionar semana:</label>
                    <input type="week" name="semana" class="form-control w-auto me-2"
                        value="<?= esc($semanaSeleccionada ?? '') ?>">
                    <button class="btn btn-primary">Filtrar</button>
                    <span class="ms-3 text-muted">Semana: <?= $inicioSemana ?> - <?= $finSemana ?></span>
                </form>

                <button class="btn btn-accent mb-3" data-bs-toggle="modal" data-bs-target="#modalCronograma">
                    Agregar tarea
                </button>

                <div class="row">
                    <?php foreach($diasSemana as $dia): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-header bg-secondary text-white fw-bold"><?= $dia ?></div>
                            <ul class="list-group list-group-flush">
                                <?php if(!empty($cronogramaSemanal[$dia])): ?>
                                <?php foreach($cronogramaSemanal[$dia] as $tarea):
                                        $tec = array_filter($tecnicos, fn($t)=>$t['id_usuario']==$tarea['id_tecnico']);
                                        $tec = reset($tec);
                                        $nombreTec = $tec ? $tec['nombre'] : 'Sin técnico';
                                    ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted"><?= esc($nombreTec) ?></small><br>
                                        <?= esc($tarea['observaciones']) ?>
                                    </div>
                                    <div>
                                        <?php if($tarea['estado'] != 'Completada'): ?>
                                        <a href="<?= base_url('jefe-taller/completar_tarea/'.$tarea['id_cronograma']) ?>"
                                            class="btn btn-success btn-sm">✔</a>
                                        <?php else: ?>
                                        <span class="badge bg-success">Completada</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <li class="list-group-item text-muted">No hay tareas</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modalAsignarTrabajo" tabindex="-1" aria-labelledby="modalAsignarTrabajoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('jefe-taller/guardar_trabajo') ?>" method="post">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Asignar Trabajo a Técnico</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_tecnico" id="tecnico_id">
                        <div class="mb-3">
                            <label class="form-label">Cliente:</label>
                            <select name="id_cliente" class="form-select" required>
                                <option value="">Seleccione un cliente</option>
                                <?php foreach($clientes as $c): ?>
                                <option value="<?= $c['id_cliente'] ?>"><?= esc($c['nombre_tienda']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de servicio:</label>
                            <input type="text" name="tipo_servicio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción:</label>
                            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCronograma" tabindex="-1" aria-labelledby="modalCronogramaLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= base_url('jefe-taller/guardar_cronograma') ?>" method="post">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title">Agregar tarea al cronograma</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Orden:</label>
                            <select name="id_orden" class="form-select" required>
                                <option value="">Seleccione una orden</option>
                                <?php foreach($ordenes as $o): ?>
                                <option value="<?= $o['id_orden'] ?>">
                                    <?= esc($o['codigo_orden']) ?> - <?= esc($o['descripcion']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Día:</label>
                            <select name="dia" class="form-select" required>
                                <option value="">Seleccione un día</option>
                                <option>Lunes</option>
                                <option>Martes</option>
                                <option>Miércoles</option>
                                <option>Jueves</option>
                                <option>Viernes</option>
                                <option>Sábado</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Guardar tarea</button>
                        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const modalAsignar = document.getElementById('modalAsignarTrabajo');
    modalAsignar.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        document.getElementById('tecnico_id').value = id;
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