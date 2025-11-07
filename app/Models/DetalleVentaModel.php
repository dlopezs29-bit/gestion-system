<?php

namespace App\Models;
use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'id_detalle';
    protected $allowedFields = ['id_venta', 'id_producto', 'cantidad', 'precio_unitario', 'subtotal'];

    // Obtener detalles por venta
    public function obtenerPorVenta($id_venta)
    {
        return $this->where('id_venta', $id_venta)->findAll();
    }

    // Crear detalle
    public function crearDetalle($data)
    {
        return $this->insert($data);
    }

    // Actualizar detalle
    public function actualizarDetalle($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar detalle
    public function eliminarDetalle($id)
    {
        return $this->delete($id);
    }
}
