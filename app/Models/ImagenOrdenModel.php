<?php

namespace App\Models;
use CodeIgniter\Model;

class ImagenOrdenModel extends Model
{
    protected $table = 'imagenes_orden';
    protected $primaryKey = 'id_imagen';
    protected $allowedFields = ['id_orden', 'ruta_imagen', 'tipo'];

    // Obtener imágenes por orden
    public function obtenerPorOrden($id_orden)
    {
        return $this->where('id_orden', $id_orden)->findAll();
    }

    // Crear imagen
    public function crearImagen($data)
    {
        return $this->insert($data);
    }

    // Eliminar imagen
    public function eliminarImagen($id)
    {
        return $this->delete($id);
    }
}
