<?php

namespace App\Models;

use CodeIgniter\Model;

class UtenteModel extends Model {
  protected $table = 'utenti';
  protected $allowedFields = ['nome', 'email', 'password', 'ruolo'];
  protected $useTimestamps = false;
  protected $returnType = 'array';
}