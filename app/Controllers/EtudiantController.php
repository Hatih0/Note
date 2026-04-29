<?php

namespace App\Controllers;

use App\Models\EtudiantModel;

class EtudiantController extends BaseController
{
    private EtudiantModel $etudiantModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
    }

    public function findAll()
    {
        $data = $this->etudiantModel->findAll();

        return view('etudiants/list', ['etudiants' => $data]);
    }
}