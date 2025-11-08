<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class LoginController extends BaseController
{
    public function index(): string
    {
        $session = session();
        if ($session->get('logged_in')) {
            return $this->redirigirPorRol($session->get('rol'));
        }

        return view('login');
    }

    public function autenticar()
    {
        $session = session();
        $usuarioModel = new UsuarioModel();

        $usuario = trim($this->request->getPost('username'));
        $password = trim($this->request->getPost('password'));

        if (empty($usuario) || empty($password)) {
            return redirect()->back()->with('error', 'Por favor, completa todos los campos.');
        }

        $userData = $usuarioModel->where('usuario', $usuario)->first();

        if (!$userData) {
            return redirect()->back()->with('error', 'El usuario no existe.');
        }

        if (!password_verify($password, $userData['password'])) {
            return redirect()->back()->with('error', 'Contraseña incorrecta.');
        }

        // Si todo es correcto
        $session->set([
            'id_usuario' => $userData['id_usuario'],
            'nombre'     => $userData['nombre'],
            'rol'        => $userData['rol'],
            'logged_in'  => true
        ]);

        return $this->redirigirPorRol($userData['rol']);
    }

    private function redirigirPorRol($rol)
    {
        switch ($rol) {
            case 'duenia': return redirect()->to('/duenia');
            case 'gerente': return redirect()->to('/gerente-general');
            case 'jefe_taller': return redirect()->to('/jefe-taller');
            case 'tecnico': return redirect()->to('/tecnicos');
            case 'jefe_ventas': return redirect()->to('/jefe-ventas');
            case 'vendedor': return redirect()->to('/vendedores');
            default: return redirect()->to('/error-sesion');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
