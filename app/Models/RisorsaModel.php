<?php

namespace App\Models;

use CodeIgniter\Model;

class RisorsaModel extends Model {
  protected $table = 'risorse';
  protected $allowedFields = ['nome', 'tipo', 'disponibilita', 'descrizione'];
  protected $returnType = 'array';


  public function findAvailableByType(string $tipo): array
    {
        return $this->builder()
            ->select('risorse.*')
            // join “destrutturante”: include prenotazioni attive di questa risorsa
            ->join('prenotazioni p', 
                   'p.risorsa_id = risorse.id AND p.stato = "attiva"', 
                   'left')
            // filtro sul tipo
            ->where('risorse.tipo', $tipo)
            // lasciamo passare solo quelle che non hanno joinato nulla
            ->where('p.id IS NULL')
            ->get()
            ->getResultArray();
    }
  public function filterResources(string $tipo, string $data_inizio, string $data_fine): array
    {
        return $this->builder()
            ->select('risorse.*')
            // join “destrutturante”: include prenotazioni attive di questa risorsa
            ->join('prenotazioni p', 
                   'p.risorsa_id = risorse.id AND p.stato = "attiva"', 
                   'left')
            // filtro sul tipo
            ->where('risorse.tipo', $tipo)
            // filtro sulle date
            ->where('p.data_inizio >=', $data_inizio)
            ->where('p.data_fine <=', $data_fine)
            // lasciamo passare solo quelle che non hanno joinato nulla
            ->where('p.id IS NULL')
            ->get()
            ->getResultArray();
    }
}