<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function index(): string
    {
        return view('login'); // Vista del login
    }

    public function autenticar()
{
    dd($this->request->getPost());
    $session = session();
    $usuarioModel = new UsuarioModel();

    $usuario = $this->request->getPost('username');
    $password = $this->request->getPost('password');

    $userData = $usuarioModel->verificarUsuario($usuario, $password);

    if ($userData) {
        $session->set([
            'id_usuario' => $userData['id_usuario'],
            'nombre'     => $userData['nombre'],
            'rol'        => $userData['rol'],
            'logged_in'  => true
        ]);

        switch ($userData['rol']) {
            case 'duenia':
                return redirect()->to('/duenia');
            case 'gerente':
                return redirect()->to('/gerente-general');
            case 'jefe_taller':
                return redirect()->to('/jefe-taller');
            case 'tecnico':
                return redirect()->to('/tecnicos');
            case 'jefe_ventas':
                return redirect()->to('/jefe-ventas');
            case 'vendedor':
                return redirect()->to('/vendedores');
            default:
                return redirect()->to('/error-sesion');
        }
    } else {
        return redirect()->back()->with('error', 'Usuario o contraseña incorrectos');
    }
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}