<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\OrdenServicioModel;
use App\Models\ClienteModel;
use App\Models\CronogramaModel;

class JefeTallerController extends BaseController
{
    protected $usuarioModel;
    protected $ordenModel;
    protected $clienteModel;
    protected $cronogramaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->ordenModel = new OrdenServicioModel();
        $this->clienteModel = new ClienteModel();
        $this->cronogramaModel = new CronogramaModel();
    }

    public function index(): string
{
    $usuarioModel = new UsuarioModel();
    $ordenModel = new OrdenServicioModel();
    $clienteModel = new ClienteModel();
    $cronogramaModel = new CronogramaModel();

    $tecnicos = $usuarioModel->where('rol', 'tecnico')->findAll();
    $ordenes = $ordenModel->obtenerOrdenes();
    $clientes = $clienteModel->findAll();

    // Obtener semana seleccionada desde GET, si no viene usar la actual
    $semana = $this->request->getGet('semana'); // formato: YYYY-Www
    $hoy = new \DateTime();

    if ($semana) {
        $inicioSemana = new \DateTime();
        $inicioSemana->setISODate(substr($semana,0,4), substr($semana,6,2));
    } else {
        $inicioSemana = clone $hoy;
        $inicioSemana->modify(('Monday' == $hoy->format('l')) ? 'this Monday' : 'last Monday');
    }

    $finSemana = clone $inicioSemana;
    $finSemana->modify('+5 days'); // Lunes a Sábado

    // Cronograma filtrado por semana
    $cronogramas = $cronogramaModel
        ->where('fecha_asignacion >=', $inicioSemana->format('Y-m-d'))
        ->where('fecha_asignacion <=', $finSemana->format('Y-m-d'))
        ->orderBy('dia', 'ASC')
        ->findAll();

    // Organizar cronograma por día
    $diasSemana = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $cronogramaSemanal = [];
    foreach($diasSemana as $dia) {
        $cronogramaSemanal[$dia] = array_filter($cronogramas, fn($t) => $t['dia']==$dia);
    }

    $data = [
        'tecnicos' => $tecnicos,
        'ordenes' => $ordenes,
        'clientes' => $clientes,
        'diasSemana' => $diasSemana,
        'cronogramaSemanal' => $cronogramaSemanal,
        'inicioSemana' => $inicioSemana->format('d/m/Y'),
        'finSemana' => $finSemana->format('d/m/Y'),
        'semanaSeleccionada' => $semana
    ];

    return view('jefeTaller', $data);
}
    // Guardar trabajo asignado
    public function guardar_trabajo()
    {
        $data = [
            'codigo_orden' => 'ORD-' . strtoupper(uniqid()),
            'id_cliente' => $this->request->getPost('id_cliente'),
            'id_tecnico' => $this->request->getPost('id_tecnico'),
            'descripcion' => $this->request->getPost('descripcion'),
            'tipo_servicio' => $this->request->getPost('tipo_servicio'),
            'estado' => 'Pendiente',
            'fecha_creacion' => date('Y-m-d H:i:s')
        ];

        $this->ordenModel->insert($data);

        return redirect()->to(base_url('jefe-taller'))->with('success', 'Trabajo asignado correctamente.');
    }

    // Guardar tarea en cronograma semanal
    public function guardar_cronograma()
    {
        $dia = $this->request->getPost('dia');
        $id_orden = $this->request->getPost('id_orden');
        $orden = $this->ordenModel->find($id_orden);

        if(!$orden){
            return redirect()->back()->with('error','Orden no encontrada.');
        }

        $data = [
            'id_tecnico' => $orden['id_tecnico'],
            'id_orden' => $id_orden,
            'dia' => $dia,
            'observaciones' => $orden['descripcion'],
            'estado' => 'Programado',
            'fecha_asignacion' => date('Y-m-d')
        ];

        $this->cronogramaModel->crearCronograma($data);

        return redirect()->to(base_url('jefe-taller'))->with('success','Tarea agregada al cronograma semanal.');
    }

    // Marcar tarea como completada
    public function completar_tarea($id_cronograma)
    {
        $tarea = $this->cronogramaModel->obtenerPorId($id_cronograma);
        if($tarea){
            $this->cronogramaModel->actualizarCronograma($id_cronograma, ['estado'=>'Completada']);
            return redirect()->to(base_url('jefe-taller'))->with('success','Tarea completada.');
        }
        return redirect()->to(base_url('jefe-taller'))->with('error','Tarea no encontrada.');
    }
}