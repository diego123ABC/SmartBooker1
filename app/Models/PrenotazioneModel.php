<?php

namespace App\Models;

use CodeIgniter\Model;

class PrenotazioneModel extends Model {
  protected $table = 'prenotazioni';
  protected $allowedFields = ['utente_id', 'risorsa_id', 'data_inizio', 'data_fine', 'stato'];
  protected $returnType = 'array';

  public function getTotalePrenotazioniPerRisorsa()
{
    return $this->select('risorse.nome AS risorsa, COUNT(prenotazioni.id) AS totale')
                ->join('risorse', 'risorse.id = prenotazioni.risorsa_id')
                ->groupBy('prenotazioni.risorsa_id')
                ->findAll();
}


}