<?php

namespace App\Models;
use CodeIgniter\Model;

class HistorialModel extends Model
{
    protected $table = 'historial';
    protected $primaryKey = 'id_historial';
    protected $allowedFields = ['id_usuario', 'accion'];

    // Obtener historial
    public function obtenerHistorial()
    {
        return $this->findAll();
    }

    // Crear registro de acción
    public function registrarAccion($data)
    {
        return $this->insert($data);
    }
}
