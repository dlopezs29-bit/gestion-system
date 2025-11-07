<?php

namespace App\Controllers;
use App\Models\VentaModel;
use App\Models\ClienteModel;
use App\Models\UsuarioModel;

class VentaController extends BaseController
{
    protected $ventaModel;
    protected $clienteModel;
    protected $usuarioModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->clienteModel = new ClienteModel();
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['ventas'] = $this->ventaModel->obtenerVentas();
        return view('ventas', $data);
    }

    public function crear()
    {
        $data['clientes'] = $this->clienteModel->findAll();
        $data['vendedores'] = $this->usuarioModel->where('rol','vendedor')->findAll();
        return view('crearVenta', $data);
    }

    public function guardar()
    {
        $data = [
            'id_vendedor' => $this->request->getPost('id_vendedor'),
            'id_cliente'  => $this->request->getPost('id_cliente'),
            'total'       => 0 // se calcula después al agregar detalle
        ];

        $this->ventaModel->insert($data);

        return redirect()->to(base_url('gerente-general/ventas'))
                         ->with('success', 'Venta creada correctamente.');
    }

    public function eliminar($id)
    {
        $this->ventaModel->delete($id);

        return redirect()->to(base_url('gerente-general/ventas'))
                         ->with('success', 'Venta eliminada correctamente.');
    }
}
