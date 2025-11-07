<?php

namespace App\Models;
use CodeIgniter\Model;

class OrdenTrabajoModel extends Model
{
    protected $table = 'ordenes_servicio';
    protected $primaryKey = 'id_orden';
    protected $allowedFields = [
        'codigo_orden', 'id_cliente', 'id_tecnico', 'tipo_servicio',
        'descripcion', 'costo_estimado', 'fecha_creacion',
        'fecha_finalizacion', 'estado', 'observaciones'
    ];

    // Obtener todas las órdenes (con cliente y técnico)
    public function obtenerOrdenesConDetalles()
    {
        return $this->select('ordenes_servicio.*, 
                              clientes.nombre_tienda AS cliente, 
                              usuarios.nombre AS tecnico')
                    ->join('clientes', 'clientes.id_cliente = ordenes_servicio.id_cliente')
                    ->join('usuarios', 'usuarios.id_usuario = ordenes_servicio.id_tecnico', 'left')
                    ->orderBy('ordenes_servicio.fecha_creacion', 'DESC')
                    ->findAll();
    }

    // Obtener órdenes pendientes o específicas
    public function obtenerPendientes()
    {
        return $this->where('estado', 'Pendiente')->findAll();
    }

    // Cambiar estado (Aprobado, Rechazado, etc.)
    public function cambiarEstado($id, $nuevoEstado)
    {
        return $this->update($id, ['estado' => $nuevoEstado]);
    }
}
