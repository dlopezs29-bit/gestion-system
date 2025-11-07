<?php

namespace App\Controllers;
use App\Models\ProductoModel;

class ProductoController extends BaseController
{
    protected $productoModel;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    public function index()
    {
        $data['productos'] = $this->productoModel->obtenerProductos();
        return view('productos', $data);
    }

    public function crear()
    {
        return view('crearProducto');
    }

    public function guardar()
    {
        $data = [
            'nombre_producto' => trim($this->request->getPost('nombre_producto')),
            'descripcion'     => trim($this->request->getPost('descripcion')),
            'categoria'       => $this->request->getPost('categoria'),
            'precio'          => $this->request->getPost('precio'),
            'stock'           => $this->request->getPost('stock'),
            'estado'          => 1
        ];

        $this->productoModel->crearProducto($data);

        return redirect()->to(base_url('gerente-general/productos'))
                         ->with('success', 'Producto creado correctamente.');
    }

    public function editar($id)
    {
        $data['producto'] = $this->productoModel->obtenerPorId($id);
        return view('editarProducto', $data);
    }

    public function actualizar($id)
    {
        $data = [
            'nombre_producto' => trim($this->request->getPost('nombre_producto')),
            'descripcion'     => trim($this->request->getPost('descripcion')),
            'categoria'       => $this->request->getPost('categoria'),
            'precio'          => $this->request->getPost('precio'),
            'stock'           => $this->request->getPost('stock'),
            'estado'          => $this->request->getPost('estado')
        ];

        $this->productoModel->actualizarProducto($id, $data);

        return redirect()->to(base_url('gerente-general/productos'))
                         ->with('success', 'Producto actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->productoModel->eliminarProducto($id);
        return redirect()->to(base_url('gerente-general/productos'))
                         ->with('success', 'Producto eliminado correctamente.');
    }
}
