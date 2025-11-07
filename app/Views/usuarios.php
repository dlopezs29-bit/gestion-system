<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Gerencia General</title>
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
                <li class="nav-item mb-2">
                    <a href="<?= base_url('gerente-general') ?>" class="nav-link"> Panel General</a>
                </li>
                <li class="nav-item mb-2">
                    <a href="<?= base_url('gerente-general/usuarios') ?>" class="nav-link active"> Usuarios</a>
                </li>
            </ul>
            <div class="mt-auto p-3">
                <a href="<?= base_url('logout') ?>" class="btn btn-outline-light w-100">Cerrar sesión</a>
            </div>
        </div>

        <div class="main-content flex-grow-1">
            <nav
                class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4 d-flex justify-content-between align-items-center">
                <h4 class="text-primary mb-0">Gestión de Usuarios</h4>
                <span class="fw-semibold text-muted">Bienvenida,
                    <span class="text-dark"><?= session('nombre') ?></span>
                </span>
            </nav>
    <div class="overlay" id="overlay"></div>
            <div class="container-fluid mt-4">

                <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="toggle-sidebar" id="toggleSidebar">☰</button>
                    <h5 class="fw-bold mb-0">Usuarios Registrados</h5>
                    <a href="<?= base_url('gerente-general/usuarios/crear') ?>" class="btn btn-success btn-sm">
                        Nuevo Usuario
                    </a>
                </div>

                <div class="card shadow-sm p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-header">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($usuarios)): ?>
                                <?php foreach ($usuarios as $i => $u): ?>
                                <tr>

                                    <td><?= $i + 1 ?></td>
                                    <td><?= esc($u['nombre']) ?></td>
                                    <td><?= esc($u['usuario']) ?></td>
                                    <td><?= esc($u['correo']) ?></td>
                                    <td><?= ucfirst(esc($u['rol'])) ?></td>
                                    <td>
                                        <?php if ($u['estado'] == 1): ?>
                                        <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                        <span class="badge bg-secondary">Inactivo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('gerente-general/usuarios/editar/'.$u['id_usuario']) ?>"
                                            class="btn btn-outline-primary btn-sm">Editar</a>
                                        <a href="<?= base_url('gerente-general/usuarios/eliminar/'.$u['id_usuario']) ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('¿Desea eliminar este usuario?')">
                                            Eliminar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No hay usuarios registrados.</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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