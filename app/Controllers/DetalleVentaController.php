<?php

namespace App\Controllers;
use App\Models\DetalleVentaModel;
use App\Models\VentaModel;
use App\Models\ProductoModel;

class DetalleVentaController extends BaseController
{
    protected $detalleModel;
    protected $ventaModel;
    protected $productoModel;

    public function __construct()
    {
        $this->detalleModel = new DetalleVentaModel();
        $this->ventaModel = new VentaModel();
        $this->productoModel = new ProductoModel();
    }

    public function index($id_venta)
    {
        $data['detalles'] = $this->detalleModel->where('id_venta', $id_venta)->findAll();
        $data['venta'] = $this->ventaModel->find($id_venta);
        return view('detalleVenta', $data);
    }

    public function agregar($id_venta)
    {
        $data['venta'] = $this->ventaModel->find($id_venta);
        $data['productos'] = $this->productoModel->where('estado',1)->findAll();
        return view('agregarDetalle', $data);
    }

    public function guardar($id_venta)
    {
        $cantidad = $this->request->getPost('cantidad');
        $producto = $this->productoModel->find($this->request->getPost('id_producto'));

        $subtotal = $producto['precio'] * $cantidad;

        $data = [
            'id_venta'      => $id_venta,
            'id_producto'   => $producto['id_producto'],
            'cantidad'      => $cantidad,
            'precio_unitario'=> $producto['precio'],
            'subtotal'      => $subtotal
        ];

        $this->detalleModel->insert($data);

        // Actualizar total de la venta
        $total = $this->detalleModel->selectSum('subtotal')->where('id_venta', $id_venta)->first()['subtotal'];
        $this->ventaModel->update($id_venta, ['total' => $total]);

        return redirect()->to(base_url('gerente-general/detalle-venta/'.$id_venta))
                         ->with('success', 'Producto agregado correctamente.');
    }

    public function eliminar($id, $id_venta)
    {
        $this->detalleModel->delete($id);

        // Actualizar total
        $total = $this->detalleModel->selectSum('subtotal')->where('id_venta', $id_venta)->first()['subtotal'] ?? 0;
        $this->ventaModel->update($id_venta, ['total' => $total]);

        return redirect()->to(base_url('gerente-general/detalle-venta/'.$id_venta))
                         ->with('success', 'Producto eliminado correctamente.');
    }
}
