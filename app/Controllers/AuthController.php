<?php

namespace App\Controllers;

use App\Models\UtenteModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function attemptLogin()
    {
        $session = session();
        $model = new UtenteModel();
        $user = $model->where('email', $this->request->getPost('email'))->first();

        if ($user && $user['password'] === $this->request->getPost('password')) {
            $session->set(['user' => $user]);
            return redirect()->to(base_url('home'))->with('success', 'Accesso effettuato con successo');
        }

        return redirect()->to(base_url())->with('error', 'Credenziali non valide');
    }

    public function attemptRegister()
    {
        $model = new UtenteModel();
        $email = $this->request->getPost('email');

        // Verifica se email è già registrata
        if ($model->where('email', $email)->first()) {
            return redirect()->to(base_url('register'))->with('error', 'Email già registrata');
        }

        $model->insert([
            'nome'     => $this->request->getPost('nome'),
            'email'    => $email,
            'password' => $this->request->getPost('password'),
            'ruolo'    => $this->request->getPost('ruolo'),
        ]);

        return redirect()->to(base_url())->with('success', 'Registrazione completata! Ora puoi accedere.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url())->with('success', 'Logout effettuato con successo');
    }
}