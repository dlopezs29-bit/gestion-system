<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\OrdenServicioModel;
use App\Models\ClienteModel;

class GerenteGeneralController extends BaseController
{
    public function index(): string
    {
        // Modelos
        $usuarioModel = new UsuarioModel();
        $ordenModel   = new OrdenServicioModel();
        $clienteModel = new ClienteModel();

        // 1) Resumen: calcular contadores básicos
        $totalPendientes = $ordenModel->where('estado', 'Pendiente')->countAllResults(false);
        $totalCompletadas = $ordenModel->where('estado', 'Completado')->countAllResults(false);
        $tecnicosActivos = $usuarioModel->where('rol', 'tecnico')->where('estado', 1)->countAllResults(false);

        // Para reportes aprobados (si usas 'Aprobada' o 'Aprobado' ajustar)
        $reportesAprobados = $ordenModel->where('estado', 'Aprobada')->countAllResults(false);

        $resumen = [
            'pendientes'  => $totalPendientes ?: 0,
            'completadas' => $totalCompletadas ?: 0,
            'tecnicos'    => $tecnicosActivos ?: 0,
            'reportes'    => $reportesAprobados ?: 0,
        ];

        // 2) Órdenes: obtener últimas órdenes (puedes limitar si quieres)
        $ordenesRaw = $ordenModel->obtenerOrdenes(); // devuelve todos
        $ordenes = [];

        foreach ($ordenesRaw as $o) {
            // obtener nombre de tienda
            $cliente = $clienteModel->obtenerPorId($o['id_cliente'] ?? null);
            $nombreTienda = $cliente ? ($cliente['nombre_tienda'] ?? 'Sin Cliente') : 'Sin Cliente';

            // obtener nombre del técnico
            $tecnico = $usuarioModel->obtenerPorId($o['id_tecnico'] ?? null);
            $nombreTecnico = $tecnico ? ($tecnico['nombre'] ?? 'Sin Técnico') : 'Sin Técnico';

            $ordenes[] = [
                'id' => $o['id_orden'],
                'codigo' => $o['codigo_orden'] ?? $o['id_orden'],
                'tienda' => $nombreTienda,
                'tecnico' => $nombreTecnico,
                'descripcion' => $o['descripcion'] ?? '',
                'fecha' => isset($o['fecha_creacion']) ? $o['fecha_creacion'] : ($o['fecha'] ?? ''),
                'estado' => $o['estado'] ?? ''
            ];
        }

        // 3) Lista de técnicos (nombres) para el filtro del panel
        $tecnicosRaw = $usuarioModel->where('rol', 'tecnico')->findAll();
        $tecnicos = [];
        foreach ($tecnicosRaw as $t) {
            $tecnicos[] = $t['nombre'];
        }

        // 4) Departamentos y destinatarios (puedes personalizarlos)
        $departamentos = ['Taller', 'Ventas', 'Contabilidad'];
        $destinatarios = ['Jefe de Taller', 'Jefe de Ventas', 'Jefe de Contabilidad'];

        // Pasar todo a la vista
        $data = [
            'resumen' => $resumen,
            'ordenes' => $ordenes,
            'tecnicos' => $tecnicos,
            'departamentos' => $departamentos,
            'destinatarios' => $destinatarios
        ];

        return view('gerenteGeneral', $data);
    }
}
