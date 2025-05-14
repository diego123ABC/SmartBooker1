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
            'risorse' => $model->where('tipo', $tipo)->findAll(),
        ];

        return view('risorse_categoria', $data);
    }
}