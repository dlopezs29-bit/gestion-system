<?php

namespace App\Controllers;
use App\Models\CronogramaModel;
use App\Models\UsuarioModel;
use App\Models\OrdenServicioModel;

class CronogramasController extends BaseController
{
    protected $cronogramaModel;
    protected $usuarioModel;
    protected $ordenModel;

    public function __construct()
    {
        $this->cronogramaModel = new CronogramaModel();
        $this->usuarioModel = new UsuarioModel();
        $this->ordenModel = new OrdenServicioModel();
    }

    public function index()
    {
        $data['cronogramas'] = $this->cronogramaModel->obtenerCronogramas();
        return view('cronogramas', $data);
    }

    public function crear()
    {
        $data['tecnicos'] = $this->usuarioModel->where('rol','tecnico')->findAll();
        $data['ordenes'] = $this->ordenModel->findAll();
        return view('crearCronograma', $data);
    }

    public function guardar()
    {
        $data = [
            'id_tecnico' => $this->request->getPost('id_tecnico'),
            'id_orden'   => $this->request->getPost('id_orden'),
            'fecha_asignacion' => $this->request->getPost('fecha_asignacion'),
            'observaciones' => trim($this->request->getPost('observaciones'))
        ];

        $this->cronogramaModel->insert($data);

        return redirect()->to(base_url('gerente-general/cronogramas'))
                         ->with('success', 'Cronograma creado correctamente.');
    }

    public function editar($id)
    {
        $data['cronograma'] = $this->cronogramaModel->find($id);
        $data['tecnicos'] = $this->usuarioModel->where('rol','tecnico')->findAll();
        $data['ordenes'] = $this->ordenModel->findAll();
        return view('editarCronograma', $data);
    }

    public function actualizar($id)
    {
        $data = [
            'id_tecnico' => $this->request->getPost('id_tecnico'),
            'id_orden'   => $this->request->getPost('id_orden'),
            'fecha_asignacion' => $this->request->getPost('fecha_asignacion'),
            'observaciones' => trim($this->request->getPost('observaciones'))
        ];

        $this->cronogramaModel->update($id, $data);

        return redirect()->to(base_url('gerente-general/cronogramas'))
                         ->with('success', 'Cronograma actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $this->cronogramaModel->delete($id);

        return redirect()->to(base_url('gerente-general/cronogramas'))
                         ->with('success', 'Cronograma eliminado correctamente.');
    }
}
