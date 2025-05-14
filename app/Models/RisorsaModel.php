<?php

namespace App\Models;

use CodeIgniter\Model;

class RisorsaModel extends Model {
  protected $table = 'risorse';
  protected $allowedFields = ['nome', 'tipo', 'disponibilita', 'descrizione'];
  protected $returnType = 'array';
}