<?php

namespace App\Controllers;

use App\Models\RisorsaModel;
use App\Models\PrenotazioneModel;

class AdminController extends BaseController
{
    public function __construct()
    {
        if (session('user')['ruolo'] !== 'admin') {
            exit('Accesso negato.');
        }
    }

    public function indexRisorse()
    {
        $model = new RisorsaModel();
        return view('admin/risorse_list', ['risorse' => $model->findAll()]);
    }

    public function nuovaRisorsa()
    {
        return view('admin/risorsa_nuova');
    }

    public function creaRisorsa()
    {
        $model = new RisorsaModel();
        $model->insert([
            'nome' => $this->request->getPost('nome'),
            'tipo' => $this->request->getPost('tipo'),
            'descrizione' => $this->request->getPost('descrizione'),
            'image' => $this->request->getPost('image')
        ]);

        return redirect()->to(base_url('admin/risorse'))->with('success', 'Risorsa aggiunta.');
    }

    public function eliminaRisorsa($id)
    {
        (new RisorsaModel())->delete($id);
        return redirect()->to(base_url('admin/risorse'))->with('success', 'Risorsa eliminata.');
    }

    public function listaPrenotazioni()
    {
        $model = new PrenotazioneModel();
        $db = \Config\Database::connect();

        $query = $db->table('prenotazioni')
            ->select('prenotazioni.*, utenti.nome as utente_nome, risorse.nome as risorsa_nome')
            ->join('utenti', 'utenti.id = prenotazioni.utente_id')
            ->join('risorse', 'risorse.id = prenotazioni.risorsa_id')
            ->orderBy('data_inizio', 'DESC')
            ->get();

        return view('admin/prenotazioni_list', ['prenotazioni' => $query->getResultArray()]);
    }

    public function eliminaPrenotazione($id)
    {
        (new PrenotazioneModel())->delete($id);
        return redirect()->to(base_url('admin/prenotazioni'))->with('success', 'Prenotazione eliminata.');
    }
}