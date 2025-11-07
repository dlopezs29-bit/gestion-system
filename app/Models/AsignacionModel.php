<?php
namespace App\Models;
use CodeIgniter\Model;

class AsignacionModel extends Model
{
    protected $table = 'asignaciones_trabajo';
    protected $primaryKey = 'id_asignacion';
    protected $allowedFields = [
        'id_tecnico', 'id_cliente', 'descripcion', 'fecha_inicio', 'fecha_fin', 'estado'
    ];

    public function obtenerAsignaciones()
    {
        return $this->findAll();
    }
}
