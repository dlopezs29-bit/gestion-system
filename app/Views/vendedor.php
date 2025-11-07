<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Vendedor | Empresa Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('css/vendedorStyle.css') ?>">

</head>

<body>
    <div class="d-flex" id="wrapper">

        <div class="sidebar">
            <div class="sidebar-header text-center py-3">
                <h4 class="fw-bold mb-0">Empresa <span class="text-accent">Aurora</span></h4>
            </div>
            <ul class="nav flex-column mt-4 px-3">
                <li class="nav-item mb-2"><a href="#clientes" class="nav-link active"> Clientes</a></li>
                <li class="nav-item mb-2"><a href="#ventas" class="nav-link"> Ventas</a></li>
                <li class="nav-item mb-2"><a href="#solicitudes" class="nav-link"> Solicitudes</a></li>
            </ul>
            <div class="mt-auto p-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light w-100">Cerrar sesión</a>
            </div>
        </div>
        <div class="overlay" id="overlay"></div>

        <div class="main-content flex-grow-1">
            <nav
                class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 d-flex justify-content-between align-items-center">
                <button class="menu-toggle" id="menuToggle">☰</button>
                <h4 class="text-primary mb-0">Panel de Vendedor</h4>
                <span class="fw-semibold text-muted">Bienvenido,
                    <span class="text-dark"><?= esc($vendedor['nombre']) ?></span>
                </span>
            </nav>

            <div class="container-fluid mt-4">


                <section id="clientes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Registro de Clientes</h5>

                    <form action="<?= base_url('vendedores/guardarCliente') ?>" method="post"
                        class="shadow-sm bg-white p-4 rounded-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nombre de la Tienda</label>
                                <input type="text" name="nombre_tienda" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Teléfono</label>
                                <input type="tel" name="telefono" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Correo</label>
                                <input type="email" name="correo" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Encargado</label>
                                <input type="text" name="encargado" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Cliente</label>
                                <select name="tipo_cliente" class="form-select">
                                    <option value="Residencial">Residencial</option>
                                    <option value="Comercial">Comercial</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control">
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-accent">Guardar Cliente</button>
                            </div>
                        </div>
                    </form>


                    <div class="table-responsive shadow-sm bg-white p-3 rounded-3 mt-4">
                        <table class="table table-hover align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Tienda</th>
                                    <th>Encargado</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($clientes)): ?>
                                <?php foreach ($clientes as $c): ?>
                                <tr>
                                    <td><?= esc($c['id_cliente']) ?></td>
                                    <td><?= esc($c['nombre_tienda']) ?></td>
                                    <td><?= esc($c['encargado']) ?></td>
                                    <td><?= esc($c['telefono']) ?></td>
                                    <td><?= esc($c['correo']) ?></td>
                                    <td><?= esc($c['tipo_cliente']) ?></td>
                                    <td><span class="badge bg-success"><?= esc($c['estado']) ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No hay clientes registrados</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>


                <section id="ventas" class="mb-5">
                    <h5 class="fw-bold mb-3"> Registro de Ventas</h5>
                    <div class="table-responsive shadow-sm bg-white p-3 rounded-3">
                        <table class="table table-hover align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>Código</th>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Costo</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($ordenes)): ?>
                                <?php foreach ($ordenes as $o): ?>
                                <tr>
                                    <td><?= esc($o['codigo_orden']) ?></td>
                                    <td><?= esc($o['cliente_nombre']) ?></td>
                                    <td><?= esc($o['tipo_servicio']) ?></td>
                                    <td>Q<?= esc($o['costo_estimado']) ?></td>
                                    <td><?= esc($o['fecha_creacion']) ?></td>
                                    <td><span class="badge bg-warning text-dark"><?= esc($o['estado']) ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No hay ventas registradas</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="solicitudes" class="mb-5">
                    <h5 class="fw-bold mb-3"> Enviar Solicitud de Servicio</h5>
                    <form action="<?= base_url('vendedores/guardarOrden') ?>" method="post"
                        class="shadow-sm bg-white p-4 rounded-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cliente</label>
                                <select name="id_cliente" class="form-select" required>
                                    <option value="">Seleccione un cliente</option>
                                    <?php foreach ($clientes as $c): ?>
                                    <option value="<?= esc($c['id_cliente']) ?>"><?= esc($c['nombre_tienda']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Servicio</label>
                                <select name="tipo_servicio" class="form-select">
                                    <option value="Instalación">Instalación</option>
                                    <option value="Mantenimiento">Mantenimiento</option>
                                    <option value="Revisión">Revisión</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Costo Estimado</label>
                                <input type="number" name="costo_estimado" class="form-control" step="0.01" min="0">
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-accent">Enviar Solicitud</button>
                            </div>
                        </div>
                    </form>
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
const toggle = document.getElementById('menuToggle');
const sidebar = document.querySelector('.sidebar');
toggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});
</script>

</html>