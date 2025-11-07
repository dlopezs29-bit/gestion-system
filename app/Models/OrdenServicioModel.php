<?php

namespace App\Models;
use CodeIgniter\Model;

class OrdenServicioModel extends Model
{
    protected $table = 'ordenes_servicio';
    protected $primaryKey = 'id_orden';
    protected $allowedFields = [
        'codigo_orden', 'id_cliente', 'id_tecnico', 'tipo_servicio',
        'descripcion', 'costo_estimado', 'fecha_creacion', 'fecha_finalizacion',
        'estado', 'observaciones'
    ];

    // Obtener todas las órdenes
    public function obtenerOrdenes()
    {
        return $this->findAll();
    }

    // Obtener orden por ID
    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    // Crear orden
    public function crearOrden($data)
    {
        return $this->insert($data);
    }

    // Actualizar orden
    public function actualizarOrden($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar orden
    public function eliminarOrden($id)
    {
        return $this->delete($id);
    }
}
