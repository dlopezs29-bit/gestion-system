<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\OrdenServicioModel;

class VendedorController extends BaseController
{
    protected $clienteModel;
    protected $ordenServicioModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->ordenServicioModel = new OrdenServicioModel();
    }

    public function index(): string
    {
        $session = session();

        // Si el usuario no está logueado, lo redirigimos
        if (!$session->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión primero.');
        }

        // Datos del usuario en sesión (nombre, rol, id, etc.)
        $vendedor = [
            'id_usuario' => $session->get('id_usuario'),
            'nombre'     => $session->get('nombre'),
            'rol'        => $session->get('rol')
        ];

        // Obtener todos los clientes
        $data['clientes'] = $this->clienteModel->obtenerClientes();

        // Obtener las órdenes con el nombre del cliente
        $db = \Config\Database::connect();
        $builder = $db->table('ordenes_servicio o');
        $builder->select('o.*, c.nombre_tienda AS cliente_nombre');
        $builder->join('clientes c', 'c.id_cliente = o.id_cliente', 'left');
        $data['ordenes'] = $builder->get()->getResultArray();

        // Pasamos los datos del vendedor
        $data['vendedor'] = $vendedor;

        return view('vendedor', $data);
    }

    // ✅ Guardar cliente
    public function guardarCliente()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión primero.');
        }

        $data = [
            'nombre_tienda' => $this->request->getPost('nombre_tienda'),
            'direccion'     => $this->request->getPost('direccion'),
            'telefono'      => $this->request->getPost('telefono'),
            'correo'        => $this->request->getPost('correo'),
            'encargado'     => $this->request->getPost('encargado'),
            'tipo_cliente'  => $this->request->getPost('tipo_cliente'),
            'estado'        => 'Activo',
        ];

        $this->clienteModel->crearCliente($data);
        return redirect()->to('/vendedores')->with('mensaje', 'Cliente guardado correctamente.');
    }

    // ✅ Guardar nueva orden
    public function guardarOrden()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/')->with('error', 'Debe iniciar sesión primero.');
        }

        $data = [
            'codigo_orden'      => 'ORD-' . time(),
            'id_cliente'        => $this->request->getPost('id_cliente'),
            'tipo_servicio'     => $this->request->getPost('tipo_servicio'),
            'descripcion'       => $this->request->getPost('descripcion'),
            'costo_estimado'    => $this->request->getPost('costo_estimado'),
            'fecha_creacion'    => date('Y-m-d'),
            'estado'            => 'Pendiente',
        ];

        $this->ordenServicioModel->crearOrden($data);
        return redirect()->to('/vendedores')->with('mensaje', 'Orden creada correctamente.');
    }
}