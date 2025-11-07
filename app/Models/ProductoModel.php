<?php

namespace App\Models;
use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields = ['nombre_producto', 'descripcion', 'categoria', 'precio', 'stock', 'estado'];

    // Obtener todos los productos
    public function obtenerProductos()
    {
        return $this->findAll();
    }

    // Obtener producto por ID
    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    // Crear producto
    public function crearProducto($data)
    {
        return $this->insert($data);
    }

    // Actualizar producto
    public function actualizarProducto($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar producto
    public function eliminarProducto($id)
    {
        return $this->delete($id);
    }
}
