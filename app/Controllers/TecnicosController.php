<?php

namespace App\Controllers;

use App\Models\OrdenServicioModel;
use App\Models\ClienteModel;
use App\Models\UsuarioModel;
use App\Models\ImagenOrdenModel;
use App\Models\HistorialModel;
use CodeIgniter\Files\File;

class TecnicosController extends BaseController
{
    public function index()
    {
        $session = session();
        $id_tecnico = $session->get('id_usuario');

        $ordenModel = new OrdenServicioModel();
        $clienteModel = new ClienteModel();

        // Órdenes asignadas al técnico
        $ordenes = $ordenModel->where('id_tecnico', $id_tecnico)->findAll();

        // Agregar nombre de cliente
        foreach ($ordenes as &$orden) {
            $cliente = $clienteModel->obtenerPorId($orden['id_cliente']);
            $orden['nombre_cliente'] = $cliente ? $cliente['nombre_tienda'] : 'Sin Cliente';
        }

        return view('tecnicos', [
            'ordenes' => $ordenes,
            'session' => $session
        ]);
    }

    // ✅ 1. Cambiar estado del técnico
    public function cambiar_estado($nuevo_estado)
    {
        $session = session();
        $usuarioModel = new UsuarioModel();
        $id_tecnico = $session->get('id_usuario');

        if (!in_array($nuevo_estado, ['disponible', 'en_campo'])) {
            return redirect()->back()->with('error', 'Estado no válido');
        }

        $usuarioModel->update($id_tecnico, ['estado' => $nuevo_estado]);
        $session->set('estado', $nuevo_estado);

        // Registrar en historial
        $this->registrarHistorial($id_tecnico, "Cambió su estado a $nuevo_estado");

        return redirect()->to('/tecnicos')->with('mensaje', 'Estado actualizado correctamente');
    }

    // ✅ 2. Crear nueva orden
    public function crear_orden()
    {
        $ordenModel = new OrdenServicioModel();
        $imagenModel = new ImagenOrdenModel();
        $session = session();
        $id_tecnico = $session->get('id_usuario');

        $data = [
            'codigo_orden' => 'ORD-' . strtoupper(uniqid()),
            'id_cliente' => $this->request->getPost('id_cliente'),
            'id_tecnico' => $id_tecnico,
            'descripcion' => $this->request->getPost('descripcion'),
            'fecha_creacion' => $this->request->getPost('fecha_creacion'),
            'estado' => 'asignada'
        ];

        $id_orden = $ordenModel->insert($data);

        // ✅ Guardar fotos si existen
        foreach (['foto_antes', 'foto_despues'] as $tipo) {
            $file = $this->request->getFile($tipo);
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $ruta = 'uploads/ordenes/';
                $nombreArchivo = $tipo . '_' . time() . '_' . $file->getName();
                $file->move($ruta, $nombreArchivo);

                $imagenModel->insert([
                    'id_orden' => $id_orden,
                    'ruta_imagen' => $ruta . $nombreArchivo,
                    'tipo' => $tipo
                ]);
            }
        }

        // Registrar acción
        $this->registrarHistorial($id_tecnico, "Creó la orden $id_orden");

        return redirect()->to('/tecnicos')->with('mensaje', 'Orden creada exitosamente');
    }

    // ✅ 3. Marcar orden como completada
    public function marcar_completa($id_orden)
    {
        $ordenModel = new OrdenServicioModel();
        $session = session();
        $id_tecnico = $session->get('id_usuario');

        $orden = $ordenModel->find($id_orden);
        if (!$orden || $orden['id_tecnico'] != $id_tecnico) {
            return redirect()->back()->with('error', 'No puedes modificar esta orden.');
        }

        $ordenModel->update($id_orden, [
            'estado' => 'completada',
            'fecha_finalizacion' => date('Y-m-d')
        ]);

        $this->registrarHistorial($id_tecnico, "Marcó la orden $id_orden como completada");

        return redirect()->to('/tecnicos')->with('mensaje', 'Orden completada correctamente');
    }

    // ✅ 4. Ver detalles de una orden
public function orden($id_orden)
{
    $ordenModel = new OrdenServicioModel();
    $clienteModel = new ClienteModel();
    $imagenModel = new ImagenOrdenModel();
    $session = session();

    $id_tecnico = $session->get('id_usuario');
    $orden = $ordenModel->find($id_orden);

    if (!$orden || $orden['id_tecnico'] != $id_tecnico) {
        return redirect()->to('/tecnicos')->with('error', 'No tienes permiso para ver esta orden.');
    }

    $cliente = $clienteModel->obtenerPorId($orden['id_cliente']);
    $imagenes = $imagenModel->obtenerPorOrden($id_orden);

    return view('tecnicosDetalle', [
        'orden' => $orden,
        'cliente' => $cliente,
        'imagenes' => $imagenes,
        'session' => $session
    ]);
}

    // ✅ Registrar acciones del técnico
    private function registrarHistorial($id_usuario, $accion)
    {
        $historialModel = new HistorialModel();
        $historialModel->insert([
            'id_usuario' => $id_usuario,
            'accion' => $accion,
            'fecha' => date('Y-m-d H:i:s')
        ]);
    }
}