<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use App\Models\OrdenServicioModel;
use App\Models\ClienteModel;

class JefeVentasController extends BaseController
{
    public function index()
    {
        $usuarioModel = new UsuarioModel();
        $ordenModel = new OrdenServicioModel();
        $clienteModel = new ClienteModel();

        // Obtener todos los vendedores
        $vendedores = $usuarioModel->where('rol', 'vendedor')->findAll();

        // Para cada vendedor, calcular clientes atendidos, ventas y monto total
        $datosVendedores = [];
        foreach($vendedores as $vendedor){
            $ordenes = $ordenModel->where('id_tecnico', $vendedor['id_usuario'])->findAll(); // Asumimos que id_tecnico = id_vendedor
            $clientesAtendidos = count($ordenes);
            $ventas = count(array_filter($ordenes, fn($o) => $o['estado'] === 'Aprobada'));
            $montoTotal = array_sum(array_map(fn($o) => floatval($o['costo_estimado'] ?? 0), $ordenes));

            // Determinar desempeño
            if($ventas >= 10) $desempeno = 'Excelente';
            elseif($ventas >= 5) $desempeno = 'Bueno';
            else $desempeno = 'Bajo';

            $datosVendedores[] = [
                'nombre' => $vendedor['nombre'],
                'clientes' => $clientesAtendidos,
                'ventas' => $ventas,
                'monto' => $montoTotal,
                'desempeno' => $desempeno
            ];
        }

        // Datos de gráficos (puedes ajustar según tus necesidades)
        $ventasMensuales = [4500, 4800, 5000, 6200, 5900, 7100, 6700, 7600]; // ejemplo
        $progresoSemanal = [75, 25]; // ejemplo: Cumplido, Pendiente

        return view('jefeVentas', [
            'vendedores' => $datosVendedores,
            'ventasMensuales' => $ventasMensuales,
            'progresoSemanal' => $progresoSemanal
        ]);
    }
}
