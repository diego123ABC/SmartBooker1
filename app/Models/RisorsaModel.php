<?php

namespace App\Models;

use CodeIgniter\Model;

class RisorsaModel extends Model {
  protected $table = 'risorse';
  protected $allowedFields = ['nome', 'tipo', 'descrizione' , 'image'];
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
            ->where('(p.id IS NULL OR CURDATE() > p.data_fine OR CURDATE() < p.data_inizio)')
            ->get()
            ->getResultArray();
    }
  public function filterResources(string $tipo, string $data_inizio, string $data_fine): array
{
    return $this->builder()
        ->select('risorse.*')
        ->join('prenotazioni p', 
               'p.risorsa_id = risorse.id 
                AND p.stato = "attiva"
                AND NOT (
                    p.data_fine <= "' . $data_inizio . '" 
                    OR p.data_inizio >= "' . $data_fine . '"
                )', 
               'left')
        ->where('risorse.tipo', $tipo)
        ->where('p.id IS NULL') // Esclude le risorse con sovrapposizioni
        ->get()
        ->getResultArray();
}

}