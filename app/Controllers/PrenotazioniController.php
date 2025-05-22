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
    public function dateOccupate($risorsa_id)
    {
        $model = new PrenotazioneModel();
        $prenotazioni = $model->where('risorsa_id', $risorsa_id)
            ->where('stato', 'attiva')
            ->findAll();

        $dateOccupate = [];
        foreach ($prenotazioni as $prenotazione) {
            $dateOccupate[] = [
                'data_inizio' => $prenotazione['data_inizio'],
                'data_fine' => $prenotazione['data_fine'],
            ];
        }

        return $dateOccupate;
    }

    public function crea($id)
    {
        $risorsaModel = new \App\Models\RisorsaModel();
        $risorsa = $risorsaModel->find($id);
        // Recupera le date occupate per la risorsa
        $dateOccupate = $this->dateOccupate($id);
        if (session('user')['ruolo'] === 'studente' && $risorsa['tipo'] !== 'aula_studio') {
            return redirect()->to(base_url('home'))->with('error', 'Puoi prenotare solo le aule studio.');
        }

        return view('prenota', ['risorsa' => $risorsa, 'dateOccupate' => $dateOccupate]);
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
        // Controlla se la risorsa è una stampante e la durata supera 1 ora
        $risorsaModel = new \App\Models\RisorsaModel();
        $risorsa = $risorsaModel->find($data['risorsa_id']);
        if ($risorsa) {
            $inizio = strtotime($data['data_inizio']);
            $fine = strtotime($data['data_fine']);
            $durata = $fine - $inizio;
            // Controlla che la durata sia positiva
            if ($durata <= 0) {
                return redirect()->back()->with('error', 'La data di inizio deve essere precedente alla data di fine.');
            }
            // Controlla che la data di inizio non sia nel passato
            if ($inizio < time()) {
                return redirect()->back()->with('error', 'La data di inizio non può essere precedente a quella attuale.');
            }
            if ($risorsa['tipo'] === 'stampante') {
                // Solo 1 ora esatta
                if ($durata !== 3600) {
                    return redirect()->back()->with('error', 'Le stampanti possono essere prenotate per 1 e una sola ora.');
                }
            } elseif (
                in_array($risorsa['tipo'], ['laboratorio', 'aula', 'aula_studio'])
            ) {
                // Minimo 2 ore, massimo 10 ore (dalle 8:00 alle 18:00)
                $oraInizio = (int)date('H', $inizio);
                $oraFine = (int)date('H', $fine);
                $minInizio = (int)date('i', $inizio);
                $minFine = (int)date('i', $fine);

                // Controlla che sia nello stesso giorno
                if (date('Y-m-d', $inizio) !== date('Y-m-d', $fine)) {
                    return redirect()->back()->with('error', 'La prenotazione deve essere nello stesso giorno.');
                }

                // Controlla fascia oraria 8:00-18:00
                if (
                    $oraInizio < 8 ||
                    $oraFine > 18 ||
                    ($oraFine === 18 && $minFine > 0) ||
                    ($oraInizio === 18 && $minInizio > 0)
                ) {
                    return redirect()->back()->with('error', 'Le prenotazioni sono consentite solo tra le 8:00 e le 18:00.');
                }

                // Minimo 2 ore, massimo 10 ore
                if ($durata < 7200) {
                    return redirect()->back()->with('error', 'La prenotazione deve durare almeno 2 ore.');
                }
                if ($durata > 36000) {
                    return redirect()->back()->with('error', 'La prenotazione può durare al massimo una giornata (10 ore).');
                }
            }
        }
        if ($risorsa && $risorsa['tipo'] === 'stampante') {
            $inizio = strtotime($data['data_inizio']);
            $fine = strtotime($data['data_fine']);
            if (($fine - $inizio) > 3600) {
                return redirect()->back()->with('error', 'Le stampanti possono essere prenotate per massimo 1 ora.');
            }
        }

        if (!$data['data_inizio'] || !$data['data_fine']) {
            return redirect()->back()->with('error', 'Inserisci una data valida per la prenotazione');
        }
        // Controlla se la risorsa è già prenotata
        $dateOccupate = $this->dateOccupate($data['risorsa_id']);
        foreach ($dateOccupate as $occupata) {
            if (
                (strtotime($data['data_inizio']) >= strtotime($occupata['data_inizio']) &&
                    strtotime($data['data_inizio']) < strtotime($occupata['data_fine'])) ||
                (strtotime($data['data_fine']) > strtotime($occupata['data_inizio']) &&
                    strtotime($data['data_fine']) <= strtotime($occupata['data_fine'])) ||
                (strtotime($data['data_inizio']) <= strtotime($occupata['data_inizio']) &&
                    strtotime($data['data_fine']) >= strtotime($occupata['data_fine']))
            ) {
                return redirect()->back()->with('error', 'La risorsa è già prenotata in questo intervallo.');
            }
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