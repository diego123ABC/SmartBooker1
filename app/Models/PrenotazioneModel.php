<?php

namespace App\Models;

use CodeIgniter\Model;

class PrenotazioneModel extends Model {
  protected $table = 'prenotazioni';
  protected $allowedFields = ['utente_id', 'risorsa_id', 'data_inizio', 'data_fine', 'stato'];
  protected $returnType = 'array';
}