<?php

namespace App\Controllers;
use App\Models\ImagenesOrdenModel;
use App\Models\OrdenServicioModel;

class ImagenesOrdenController extends BaseController
{
    protected $imagenModel;
    protected $ordenModel;

    public function __construct()
    {
        $this->imagenModel = new ImagenesOrdenModel();
        $this->ordenModel = new OrdenServicioModel();
    }

    public function index()
    {
        $data['imagenes'] = $this->imagenModel->findAll();
        return view('imagenesOrden', $data);
    }

    public function crear()
    {
        $data['ordenes'] = $this->ordenModel->findAll();
        return view('crearImagenOrden', $data);
    }

    public function guardar()
    {
        $file = $this->request->getFile('imagen');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/ordenes', $newName);

            $data = [
                'id_orden' => $this->request->getPost('id_orden'),
                'ruta_imagen' => 'uploads/ordenes/'.$newName,
                'tipo' => $this->request->getPost('tipo')
            ];

            $this->imagenModel->insert($data);

            return redirect()->to(base_url('gerente-general/imagenes-orden'))
                             ->with('success', 'Imagen subida correctamente.');
        }
        return redirect()->back()->with('error', 'Error al subir la imagen.');
    }

    public function eliminar($id)
    {
        $imagen = $this->imagenModel->find($id);
        if ($imagen && file_exists($imagen['ruta_imagen'])) {
            unlink($imagen['ruta_imagen']);
        }

        $this->imagenModel->delete($id);

        return redirect()->to(base_url('gerente-general/imagenes-orden'))
                         ->with('success', 'Imagen eliminada correctamente.');
    }
}
