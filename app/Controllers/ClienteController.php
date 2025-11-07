<?php

namespace App\Controllers;
use App\Models\ClienteModel;

class ClienteController extends BaseController
{
    protected $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        $data['clientes'] = $this->clienteModel->obtenerClientes();
        return view('clientes', $data);
    }

    public function crear()
    {
        return view('crearCliente');
    }

    public function guardar()
    {
        $data = [
            'nombre_tienda' => trim($this->request->getPost('nombre_tienda')),
            'direccion'     => trim($this->request->getPost('direccion')),
            'telefono'      => trim($this->request->getPost('telefono')),
            'correo'        => trim($this->request->getPost('correo')),
            'encargado'     => trim($this->request->getPost('encargado')),
            'estado'        => 1
        ];

        $this->clienteModel->crearCliente($data);

        return redirect()->to(base_url('gerente-general/clientes'))
                         ->with('success', 'Cliente creado correctamente.');
    }

    public function editar($id)
    {
        $data['cliente'] = $this->clienteModel->obtenerPorId($id);
        return view('editarCliente', $data);
    }

    public function actualizar($id)
    {
        $data = [
            'nombre_tienda' => trim($this->request->getPost('nombre_tienda')),
            'direccion'     => trim($this->request->getPost('direccion')),
            'telefono'      => trim($this->request->getPost('telefono')),
            'correo'        => trim($this->request->getPost('correo')),
            'encargado'     => trim($this->request->getPost('encargado')),
            'estado'        => $this->request->getPost('estado'),
        ];

        $this->clienteModel->actualizarCliente($id, $data);

        return redirect()->to(base_url('gerente-general/clientes'))
                         ->with('success', 'Cliente actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->clienteModel->eliminarCliente($id);
        return redirect()->to(base_url('gerente-general/clientes'))
                         ->with('success', 'Cliente eliminado correctamente.');
    }
}
