<?php

namespace App\Controllers;

use App\Models\StatusModel;

class StatusController extends BaseController
{
    public function index()
    {
        $model = new StatusModel();
        $data['status']       = $model->findAll();
        $data['pageTitle']    = 'Statuts';
        $data['pageSubtitle'] = 'Côté opérateur · Avec frais / sans frais';
        $data['activeNav']    = 'status';
        return view('status/index', $data);
    }

    public function save()
    {
        $model = new StatusModel();
        $model->save(['libelle' => $this->request->getPost('libelle')]);
        return redirect()->to('/status')->with('success', 'Statut ajouté avec succès.');
    }

    public function delete($id)
    {
        $model = new StatusModel();
        $model->delete($id);
        return redirect()->to('/status')->with('success', 'Statut supprimé.');
    }
}