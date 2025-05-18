<?php

namespace App\Controllers;

use App\Models\PrenotazioneModel;

class PrenotazioniController extends BaseController
{
    public function __construct()
    {
        // Inietta il service dal container
        $this->prenotazioneService = service('prenotazioneService');
    }


    public function crea($id)
    {
        $risorsaModel = new \App\Models\RisorsaModel();
        $risorsa = $risorsaModel->find($id);

        if (session('user')['ruolo'] === 'studente' && $risorsa['tipo'] !== 'aula_studio') {
            return redirect()->to(base_url('home'))->with('error', 'Puoi prenotare solo le aule studio.');
        }

        return view('prenota', ['risorsa_id' => $risorsa['id']]);
    }


    public function salva()
    {
        $model = new PrenotazioneModel();
        $data = [
            'utente_id'   => session('user')['id'],
            'risorsa_id'  => $this->request->getPost('risorsa_id'),
            'data_inizio' => $this->request->getPost('data_inizio'),
            'data_fine'   => $this->request->getPost('data_fine'),
        ];

        if (!$data['data_inizio'] || !$data['data_fine']) {
            return redirect()->back()->with('error', 'Inserisci una data valida per la prenotazione');
        }

        $model->insert($data);

        return redirect()->to(base_url('home'))->with('success', 'Prenotazione effettuata con successo!');
    }

    public function annulla($id)
    {
        $model = new PrenotazioneModel();

        // Verifica che la prenotazione appartenga all’utente ed è attiva
        $prenotazione = $model->where([
            'id' => $id,
            'utente_id' => session('user')['id'],
            'stato' => 'attiva'
        ])->first();

        if (!$prenotazione) {
            return redirect()->to(base_url('prenotazioni'))->with('error', 'Prenotazione non trovata o non annullabile.');
        }

        $model->update($id, ['stato' => 'cancellata']);

        return redirect()->to(base_url('prenotazioni'))->with('success', 'Prenotazione annullata con successo.');
    }

    private function aggiornaStatoPrenotazioni()
{
    // Esegue l’update e recupera il numero di righe cambiate
        $count = $this->prenotazioneService->aggiornaScadute();

        // (Opzionale) Flash message per debugging o UI
        if ($count > 0) {
            session()->setFlashdata('success', "Aggiornate {$count} prenotazioni scadute.");
        }
}

    public function miePrenotazioni()
    {

        $this->aggiornaStatoPrenotazioni();
        $model = new PrenotazioneModel();
        $db = \Config\Database::connect();

        $query = $db->table('prenotazioni')
            ->select('prenotazioni.*, risorse.nome as risorsa_nome, risorse.tipo as risorsa_tipo')
            ->join('risorse', 'risorse.id = prenotazioni.risorsa_id')
            ->where('utente_id', session('user')['id'])
            ->orderBy('data_inizio', 'DESC')
            ->get();

        $data['prenotazioni'] = $query->getResultArray();

        return view('mie_prenotazioni', $data);
    }

}