<?php

namespace App\Models;
use CodeIgniter\Model;

class ReporteModel extends Model
{
    protected $table = 'historial';
    protected $primaryKey = 'id_historial';
    protected $allowedFields = ['id_usuario', 'accion', 'fecha'];

    // Obtener reportes (acciones) con usuario
    public function obtenerReportes()
    {
        return $this->select('historial.*, usuarios.nombre AS usuario, usuarios.rol')
                    ->join('usuarios', 'usuarios.id_usuario = historial.id_usuario', 'left')
                    ->orderBy('fecha', 'DESC')
                    ->findAll();
    }

    // Filtro por técnico
    public function filtrarPorTecnico($nombre)
    {
        return $this->select('historial.*, usuarios.nombre AS usuario')
                    ->join('usuarios', 'usuarios.id_usuario = historial.id_usuario')
                    ->like('usuarios.nombre', $nombre)
                    ->findAll();
    }

    // Filtro por rol (departamento)
    public function filtrarPorRol($rol)
    {
        return $this->select('historial.*, usuarios.nombre AS usuario')
                    ->join('usuarios', 'usuarios.id_usuario = historial.id_usuario')
                    ->where('usuarios.rol', $rol)
                    ->findAll();
    }
}
