<?php

namespace App\Controllers;

use App\Models\RisorsaModel;

class HomeController extends BaseController
{
    public function index()
    {
        return view('home');
    }

    public function categoria($tipo)
    {
        $model = new RisorsaModel();
        $data = [
            'tipo' => ucfirst($tipo),
            'risorse' => $model->findAvailableByType($tipo)
        ];
        
        return view('risorse_categoria', $data);
    }

    public function filtraRisorse()
    {
        $tipo = $this->request->getGet('tipo');
        $data_inizio = $this->request->getGet('data_inizio');
        $data_fine = $this->request->getGet('data_fine');

        if (strtotime($data_inizio) > strtotime($data_fine)) {
            return redirect()->back()->with('error', 'La data di inizio non può essere successiva alla data di fine.');
        }

        if (strtotime($data_inizio) < strtotime(date('Y-m-d'))) {
            return redirect()->back()->with('error', 'La data di inizio non può essere precedente a oggi.');
        }
        $model = new RisorsaModel();
        $risorse = $model->filterResources($tipo, $data_inizio, $data_fine);

        return view('risorse_categoria', ['risorse' => $risorse, 'data_inizio' => $data_inizio, 'data_fine' => $data_fine]);
    }
}