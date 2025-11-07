<?php

namespace App\Controllers;
use App\Models\OrdenServicioModel;
use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class OrdenServicioController extends BaseController
{
    protected $ordenModel;
    protected $clienteModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->ordenModel = new OrdenServicioModel();
        $this->clienteModel = new ClienteModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['ordenes'] = $this->ordenModel->obtenerOrdenes();
        return view('ordenes', $data);
    }

    public function crear()
    {
        $data['clientes'] = $this->clienteModel->obtenerClientes();
        $data['tecnicos'] = $this->usuarioModel->where('rol','tecnico')->findAll();
        return view('crearOrden', $data);
    }

    public function guardar()
    {
        $data = [
            'codigo_orden' => 'ORD-'.time(),
            'id_cliente'   => $this->request->getPost('id_cliente'),
            'id_tecnico'   => $this->request->getPost('id_tecnico'),
            'tipo_servicio'=> $this->request->getPost('tipo_servicio'),
            'descripcion'  => trim($this->request->getPost('descripcion')),
            'estado'       => 'Pendiente'
        ];

        $this->ordenModel->crearOrden($data);

        return redirect()->to(base_url('gerente-general/ordenes'))
                         ->with('success', 'Orden creada correctamente.');
    }

    public function editar($id)
    {
        $data['orden'] = $this->ordenModel->obtenerPorId($id);
        $data['clientes'] = $this->clienteModel->obtenerClientes();
        $data['tecnicos'] = $this->usuarioModel->where('rol','tecnico')->findAll();
        return view('editarOrden', $data);
    }

    public function actualizar($id)
    {
        $data = [
            'id_cliente'    => $this->request->getPost('id_cliente'),
            'id_tecnico'    => $this->request->getPost('id_tecnico'),
            'tipo_servicio' => $this->request->getPost('tipo_servicio'),
            'descripcion'   => trim($this->request->getPost('descripcion')),
            'estado'        => $this->request->getPost('estado')
        ];

        $this->ordenModel->actualizarOrden($id, $data);

        return redirect()->to(base_url('gerente-general/ordenes'))
                         ->with('success', 'Orden actualizada correctamente.');
    }

    public function eliminar($id)
    {
        $this->ordenModel->eliminarOrden($id);
        return redirect()->to(base_url('gerente-general/ordenes'))
                         ->with('success', 'Orden eliminada correctamente.');
    }
}
