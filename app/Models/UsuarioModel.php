<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['nombre', 'usuario', 'password', 'rol', 'correo', 'estado'];

    // ✅ Verificar usuario al iniciar sesión
    public function verificarUsuario($usuario, $password)
    {
        $user = $this->where('usuario', $usuario)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    // ✅ Obtener todos los usuarios
    public function obtenerUsuarios()
    {
        return $this->findAll();
    }

    // ✅ Obtener usuario por ID
    public function obtenerPorId($id)
    {
        return $this->find($id);
    }

    // ✅ Crear usuario
    public function crearUsuario($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    // ✅ Actualizar usuario
    public function actualizarUsuario($id, $data)
    {
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']); // no se modifica la contraseña si está vacía
        }
        return $this->update($id, $data);
    }

    // ✅ Eliminar usuario
    public function eliminarUsuario($id)
    {
        return $this->delete($id);
    }
}
