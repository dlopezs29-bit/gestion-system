<?php

namespace App\Models;
use CodeIgniter\Model;

class ObservacionModel extends Model
{
    protected $table = 'observaciones';
    protected $primaryKey = 'id_observacion';
    protected $allowedFields = ['remitente_id', 'destinatario_rol', 'mensaje', 'fecha_envio'];

    // Obtener todas las observaciones
    public function obtenerTodas()
    {
        return $this->select('observaciones.*, usuarios.nombre AS remitente')
                    ->join('usuarios', 'usuarios.id_usuario = observaciones.remitente_id')
                    ->orderBy('fecha_envio', 'DESC')
                    ->findAll();
    }

    // Enviar nueva observación
    public function enviarObservacion($data)
    {
        return $this->insert($data);
    }
}
