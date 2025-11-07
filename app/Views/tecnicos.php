<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Técnico | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/tecnicosStyle.css') ?>">
</head>

<body>
    <div class="d-flex" id="wrapper">

        <div class="sidebar">
            <div class="sidebar-header text-center py-3">
                <h4 class="fw-bold mb-0">Empresa <span class="text-accent">Aurora</span></h4>
            </div>
            <ul class="nav flex-column mt-4 px-3">
                <li class="nav-item mb-2"><a href="#estado" class="nav-link active"> Estado Actual</a></li>
                <li class="nav-item mb-2"><a href="#ordenes" class="nav-link"> Mis Órdenes</a></li>
                <li class="nav-item mb-2"><a href="#crearOrden" class="nav-link"> Nueva Orden</a></li>
                <li class="nav-item mb-2"><a href="#historial" class="nav-link"> Historial</a></li>
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
                <h4 class="text-primary mb-0">Panel de los técnicos</h4>
                <span class="fw-semibold text-muted">
                    Bienvenido, <span class="text-dark"><?= esc($session->get('nombre')) ?></span>
                </span>
            </nav>

            <div class="container mt-4">


                <section id="estado" class="mb-5">
                    <h5 class="fw-bold mb-3"> Estado Actual</h5>
                    <div class="card shadow-sm p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <?php
                                    $estado_tecnico = $session->get('estado') ?? 'disponible';
                                    $badgeClass = $estado_tecnico === 'en_campo' ? 'warning text-dark' : 'success';
                                    $textoEstado = $estado_tecnico === 'en_campo' ? 'En Campo' : 'Disponible';
                                ?>
                                <p class="mb-1">Estado: <span
                                        class="badge bg-<?= $badgeClass ?>"><?= $textoEstado ?></span></p>
                            </div>
                            <div>
                                <a href="<?= base_url('tecnicos/cambiar_estado/en_campo') ?>"
                                    class="btn btn-outline-warning btn-sm me-2">En Campo</a>
                                <a href="<?= base_url('tecnicos/cambiar_estado/disponible') ?>"
                                    class="btn btn-outline-success btn-sm">Disponible</a>
                            </div>
                        </div>
                    </div>
                </section>

                <hr>


                <section id="ordenes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Mis Órdenes Actuales</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>ID</th>
                                    <th>Tienda</th>
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
                                    <td><?= esc($orden['codigo_orden']) ?></td>
                                    <td><?= esc($orden['nombre_cliente']) ?></td>
                                    <td><?= esc($orden['descripcion']) ?></td>
                                    <td><?= esc($orden['fecha_creacion']) ?></td>
                                    <td>
                                        <?php
                                                    $badgeClass = 'secondary';
                                                    $textEstado = 'Asignada';
                                                    if ($orden['estado'] === 'en_progreso') { $badgeClass = 'warning text-dark'; $textEstado = 'En Progreso'; }
                                                    if ($orden['estado'] === 'completada') { $badgeClass = 'success'; $textEstado = 'Completada'; }
                                                ?>
                                        <span class="badge bg-<?= $badgeClass ?>"><?= $textEstado ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('tecnicos/orden/'.$orden['id_orden']) ?>"
                                            class="btn btn-outline-primary btn-sm">Ver Detalles</a>
                                        <?php if($orden['estado'] !== 'completada'): ?>
                                        <a href="<?= base_url('tecnicos/marcar_completa/'.$orden['id_orden']) ?>"
                                            class="btn btn-outline-success btn-sm">Marcar como Completa</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No hay órdenes asignadas.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <hr>


                <section id="crearOrden" class="mb-5">
                    <h5 class="fw-bold mb-3"> Crear Nueva Orden de Trabajo</h5>
                    <form action="<?= base_url('tecnicos/crear_orden') ?>" method="post" enctype="multipart/form-data"
                        class="shadow-sm p-4 bg-white rounded-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tienda / Cliente</label>
                                <select name="id_cliente" class="form-select" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php
                                        $clienteModel = new \App\Models\ClienteModel();
                                        $clientes = $clienteModel->obtenerClientes();
                                        foreach($clientes as $cliente):
                                    ?>
                                    <option value="<?= $cliente['id_cliente'] ?>"><?= esc($cliente['nombre_tienda']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha_creacion" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción del Trabajo</label>
                                <textarea name="descripcion" class="form-control" rows="3"
                                    placeholder="Describa el problema o tarea realizada..." required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto Antes</label>
                                <input type="file" name="foto_antes" class="form-control" accept="image/*">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto Después</label>
                                <input type="file" name="foto_despues" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="mt-4 text-end">
                            <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                            <button type="submit" class="btn btn-accent">Guardar Orden</button>
                        </div>
                    </form>
                </section>

                <hr>

                <section id="historial" class="mb-5">
                    <h5 class="fw-bold mb-3">📚 Historial de Órdenes</h5>
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>ID</th>
                                    <th>Acción</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $historialModel = new \App\Models\HistorialModel();
                                    $historiales = $historialModel->where('id_usuario', $session->get('id_usuario'))
                                                                  ->orderBy('fecha','DESC')
                                                                  ->findAll();
                                ?>
                                <?php if(!empty($historiales)): ?>
                                <?php foreach($historiales as $hist): ?>
                                <tr>
                                    <td><?= $hist['id_historial'] ?></td>
                                    <td><?= esc($hist['accion']) ?></td>
                                    <td><?= date('Y-m-d H:i', strtotime($hist['fecha'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No hay historial registrado.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </div>
    </div>
    <footer class="text-center mt-5 py-3 bg-light border-top">
        <p class="mb-2 fw-bold">Síguenos en redes sociales</p>
        <div>
            <a href="https://facebook.com" target="_blank" class="mx-2 text-decoration-none text-primary">
                <i class="bi bi-facebook fs-4"></i>
            </a>
            <a href="https://instagram.com" target="_blank" class="mx-2 text-decoration-none text-danger">
                <i class="bi bi-instagram fs-4"></i>
            </a>
            <a href="https://twitter.com" target="_blank" class="mx-2 text-decoration-none text-info">
                <i class="bi bi-twitter fs-4"></i>
            </a>
        </div>
        <p class="mt-3 text-muted mb-0">© <?= date('Y') ?> La Aurora | Todos los derechos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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