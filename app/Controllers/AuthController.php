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
        $model   = new UtenteModel();
        $email   = $this->request->getPost('email');
        $pass    = $this->request->getPost('password');

        // Recupera l’utente per email
        $user = $model->where('email', $email)->first();

        // Verifica che esista e che la password corrisponda
        if ($user && password_verify($pass, $user['password'])) {

            unset($user['password']); // Rimuovo la password hashata da i dati dell'utente, per non salvarla nella session
            $session->set('user', $user); // Salvo l'utente in sessione, con la relativa chiave per SSO

            return redirect()->to(base_url('home'))
                            ->with('success', 'Accesso effettuato con successo');
        }

        return redirect()->to(base_url())
                        ->with('error', 'Credenziali non valide');
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
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
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