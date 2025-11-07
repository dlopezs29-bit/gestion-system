<?php

namespace App\Models;
use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = ['nombre_tienda', 'direccion', 'telefono', 'correo', 'encargado', 'tipo_cliente', 'estado'];

    // Obtener todos los clientes
    public function obtenerClientes()
    {
        return $this->findAll();
    }

    // Obtener cliente por ID
    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    // Crear cliente
    public function crearCliente($data)
    {
        return $this->insert($data);
    }

    // Actualizar cliente
    public function actualizarCliente($id, $data)
    {
        return $this->update($id, $data);
    }

    // Eliminar cliente
    public function eliminarCliente($id)
    {
        return $this->delete($id);
    }
}
