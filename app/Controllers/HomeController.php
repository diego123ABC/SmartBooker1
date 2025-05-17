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

        $model = new RisorsaModel();
        $risorse = $model->filterResources($tipo, $data_inizio, $data_fine);

        return view('risorse_categoria', ['risorse' => $risorse, 'data_inizio' => $data_inizio, 'data_fine' => $data_fine]);
    }
}