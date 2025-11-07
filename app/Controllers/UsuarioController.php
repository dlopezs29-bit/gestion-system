<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->obtenerUsuarios();
        return view('usuarios', $data);
    }

    public function crear()
    {
        return view('crearUsuario');
    }

    public function guardar()
    {
        $data = [
            'nombre'   => trim($this->request->getPost('nombre')),
            'usuario'  => trim($this->request->getPost('usuario')),
            'correo'   => trim($this->request->getPost('correo')),
            'password' => trim($this->request->getPost('password')),
            'rol'      => $this->request->getPost('rol'),
            'estado'   => 1
        ];

        $this->usuarioModel->crearUsuario($data);

        return redirect()->to(base_url('gerente-general/usuarios'))
                         ->with('success', 'Usuario creado correctamente.');
    }

    public function editar($id)
    {
        $data['usuario'] = $this->usuarioModel->obtenerPorId($id);
        return view('editarUsuario', $data);
    }

    public function actualizar($id)
    {
        $data = [
            'nombre'   => trim($this->request->getPost('nombre')),
            'usuario'  => trim($this->request->getPost('usuario')),
            'correo'   => trim($this->request->getPost('correo')),
            'rol'      => $this->request->getPost('rol'),
            'estado'   => $this->request->getPost('estado'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = trim($this->request->getPost('password'));
        }

        $this->usuarioModel->actualizarUsuario($id, $data);

        return redirect()->to(base_url('gerente-general/usuarios'))
                         ->with('success', 'Usuario actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->usuarioModel->eliminarUsuario($id);

        return redirect()->to(base_url('gerente-general/usuarios'))
                         ->with('success', 'Usuario eliminado correctamente.');
    }
}
