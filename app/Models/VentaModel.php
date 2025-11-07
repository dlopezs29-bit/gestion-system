<?php

namespace App\Models;
use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';
    protected $allowedFields = ['id_vendedor', 'id_cliente', 'fecha_venta', 'metodo_pago', 'total'];

    // Obtener todas las ventas
    public function obtenerVentas()
    {
        return $this->findAll();
    }

    // Obtener venta por ID
    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    // Crear venta
    public function crearVenta($data)
    {
        return $this->insert($data);
    }

    // Actualizar venta
    public function actualizarVenta($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar venta
    public function eliminarVenta($id)
    {
        return $this->delete($id);
    }
}
