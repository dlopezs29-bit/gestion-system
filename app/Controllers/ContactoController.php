<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ContactoController extends BaseController
{
    public function index()
    {
        return view('contacto');
    }

    public function enviar()
    {
        // Recibir los datos del formulario
        $nombre = $this->request->getPost('nombre');
        $correo = $this->request->getPost('correo');
        $mensaje = $this->request->getPost('mensaje');

        // Aquí podrías guardar en BD o enviar correo real, por ahora solo simulamos
        session()->setFlashdata('success', 'Tu mensaje fue enviado correctamente. ¡Gracias por contactarnos!');

        return redirect()->to('/contacto');
    }
}