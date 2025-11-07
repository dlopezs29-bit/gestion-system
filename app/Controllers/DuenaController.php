<?php

namespace App\Controllers;

use App\Models\OrdenTrabajoModel;
use App\Models\UsuarioModel;
use App\Models\ClienteModel;
use App\Models\ReporteModel;

class DuenaController extends BaseController
{
    public function index()
{
    $ordenModel = new OrdenTrabajoModel();
    $usuarioModel = new UsuarioModel();
    $clienteModel = new ClienteModel();
    $reporteModel = new ReporteModel();

    // 🔹 Obtener datos base
    $ordenes = $ordenModel->orderBy('fecha_creacion', 'DESC')->findAll();
    $usuarios = $usuarioModel->findAll();
    $clientes = $clienteModel->findAll();
    $reportes = $reporteModel->obtenerReportes();

    // 🔹 Clonar modelo para evitar conflictos en los conteos
    $ordenModel1 = clone $ordenModel;
    $ordenModel2 = clone $ordenModel;
    $usuarioModel1 = clone $usuarioModel;

    // 🔹 Conteos globales
    $ordenesActivas = $ordenModel1
        ->where('LOWER(estado) !=', 'completada')
        ->countAllResults();

    $ordenesCompletadas = $ordenModel2
        ->where('LOWER(estado)', 'completada')
        ->countAllResults();

    $empleadosTotales = $usuarioModel1->countAllResults();

    // 🔹 Departamentos
    $departamentos = [
        'Taller' => $usuarioModel->where('rol', 'tecnico')->countAllResults(),
        'Ventas' => $usuarioModel->where('rol', 'vendedor')->countAllResults(),
        'Gerencia' => $usuarioModel->where('rol', 'gerente')->countAllResults(),
        'Contabilidad' => $usuarioModel->where('rol', 'jefe_ventas')->countAllResults(),
    ];

    // 🔹 Rendimiento por técnico
    $tecnicos = $usuarioModel->where('rol', 'tecnico')->findAll();
    $rendimientoTecnicos = [];
    foreach ($tecnicos as $tec) {
        $ordenModelTemp = clone $ordenModel;
        $rendimientoTecnicos[] = [
            'nombre' => $tec['nombre'],
            'total' => $ordenModelTemp
                ->where('id_tecnico', $tec['id_usuario'])
                ->where('LOWER(estado)', 'completada')
                ->countAllResults(),
        ];
    }

    // 🔹 Órdenes por departamento
    $rolesDept = [
        'tecnico' => 'Taller',
        'vendedor' => 'Ventas',
        'gerente' => 'Gerencia',
        'jefe_ventas' => 'Contabilidad',
    ];

    $ordenesPorDept = [];
    foreach ($rolesDept as $rol => $nombreDept) {
        $usuariosDept = $usuarioModel->where('rol', $rol)->findColumn('id_usuario');
        $totalDept = 0;
        if ($usuariosDept) {
            $ordenModelTemp = clone $ordenModel;
            $totalDept = $ordenModelTemp->whereIn('id_tecnico', $usuariosDept)->countAllResults();
        }
        $ordenesPorDept[$nombreDept] = $totalDept;
    }

    // 🔹 Enviar datos a la vista
    $data = [
        'ordenes' => $ordenes,
        'usuarios' => $usuarios,
        'clientes' => $clientes,
        'reportes' => $reportes,
        'ordenesActivas' => $ordenesActivas,
        'ordenesCompletadas' => $ordenesCompletadas,
        'empleadosTotales' => $empleadosTotales,
        'departamentos' => $departamentos,
        'rendimientoTecnicos' => $rendimientoTecnicos,
        'ordenesPorDept' => $ordenesPorDept,
    ];

    return view('duenia', $data);
}




    // 🔹 NUEVO MÉTODO: vista dinámica por departamento
    public function verDepartamento($rol)
    {
        $ordenModel = new OrdenTrabajoModel();
        $usuarioModel = new UsuarioModel();
        $reporteModel = new ReporteModel();

        // 🔹 Mapeo de roles a nombres visibles
        $rolesDept = [
            'tecnico' => 'Taller',
            'vendedor' => 'Ventas',
            'gerente' => 'Gerencia',
            'jefe_ventas' => 'Contabilidad',
        ];

        if (!isset($rolesDept[$rol])) {
            return redirect()->to(base_url('/duenia'))->with('error', 'Departamento no válido.');
        }

        $departamentoNombre = $rolesDept[$rol];

        // 🔹 Usuarios del departamento
        $usuariosDept = $usuarioModel->where('rol', $rol)->findAll();
        $usuariosIds = array_column($usuariosDept, 'id_usuario');

        // 🔹 Órdenes relacionadas con el departamento
        $totalOrdenes = $usuariosIds ? $ordenModel->whereIn('id_tecnico', $usuariosIds)->countAllResults() : 0;
        $ordenesCompletadas = $usuariosIds ? $ordenModel->whereIn('id_tecnico', $usuariosIds)->where('estado', 'Completado')->countAllResults() : 0;
        $ordenesActivas = $usuariosIds ? $ordenModel->whereIn('id_tecnico', $usuariosIds)->where('estado !=', 'Completado')->countAllResults() : 0;

        // 🔹 Rendimiento individual
        $rendimiento = [];
        foreach ($usuariosDept as $u) {
            $total = $ordenModel
                ->where('id_tecnico', $u['id_usuario'])
                ->where('estado', 'Completado')
                ->countAllResults();

            $rendimiento[] = [
                'nombre' => $u['nombre'],
                'total' => $total
            ];
        }

        // 🔹 Reportes del departamento (JOIN con historial)
        $reportes = $usuariosIds
            ? $reporteModel->select('historial.*, usuarios.nombre AS usuario, usuarios.rol')
                ->join('usuarios', 'usuarios.id_usuario = historial.id_usuario', 'left')
                ->whereIn('historial.id_usuario', $usuariosIds)
                ->orderBy('fecha', 'DESC')
                ->findAll()
            : [];

        // 🔹 Enviar datos a la vista
        $data = [
            'departamentoNombre' => $departamentoNombre,
            'totalUsuarios' => count($usuariosDept),
            'totalOrdenes' => $totalOrdenes,
            'ordenesCompletadas' => $ordenesCompletadas,
            'ordenesActivas' => $ordenesActivas,
            'rendimiento' => $rendimiento,
            'reportes' => $reportes,
        ];

        return view('departamentos', $data);
    }

    public function toggleEstado($id_usuario)
{
    $usuarioModel = new \App\Models\UsuarioModel();

    $usuario = $usuarioModel->find($id_usuario);
    if (!$usuario) {
        return redirect()->to(base_url('duenia'))->with('error', 'Usuario no encontrado.');
    }

    $nuevoEstado = $usuario['estado'] ? 0 : 1;
    $usuarioModel->update($id_usuario, ['estado' => $nuevoEstado]);

    // Registrar acción en historial
    $reporteModel = new \App\Models\ReporteModel();
    $session = session();
    $accion = $nuevoEstado ? 'Activó al usuario ' . $usuario['nombre'] : 'Desactivó al usuario ' . $usuario['nombre'];
    $reporteModel->insert([
        'id_usuario' => $session->get('id_usuario'),
        'accion' => $accion,
        'fecha' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to(base_url('duenia'))->with('success', 'Estado del usuario actualizado.');
}


public function editarUsuario($id_usuario)
{
    $usuarioModel = new \App\Models\UsuarioModel();
    $usuario = $usuarioModel->find($id_usuario);

    if (!$usuario) {
        return redirect()->to(base_url('duenia'))->with('error', 'Usuario no encontrado.');
    }

    return view('editarUsuario', ['usuario' => $usuario]);
}

}