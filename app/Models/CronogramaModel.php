<?php

namespace App\Models;
use CodeIgniter\Model;

class CronogramaModel extends Model
{
    protected $table = 'cronogramas';
    protected $primaryKey = 'id_cronograma';
    protected $allowedFields = [
        'id_tecnico',
        'id_orden',
        'fecha_asignacion',
        'hora_inicio',
        'hora_fin',
        'observaciones',
        'dia',
        'estado'
    ];

    // ✅ Obtener todos los cronogramas
    public function obtenerCronogramas()
    {
        return $this->findAll();
    }

    // ✅ Obtener cronograma por ID
    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    // ✅ Crear cronograma
    public function crearCronograma($data)
    {
        if (!isset($data['estado'])) {
            $data['estado'] = 'Programado';
        }
        return $this->insert($data);
    }

    // ✅ Actualizar cronograma
    public function actualizarCronograma($id, $data)
    {
        return $this->update($id, $data);
    }

    // ✅ Eliminar cronograma
    public function eliminarCronograma($id)
    {
        return $this->delete($id);
    }
}
