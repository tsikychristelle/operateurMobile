<?php

namespace App\Controllers;

use App\Models\IntervalMontantModel;

class IntervalMontantController extends BaseController
{
    public function index()
    {
        $model = new IntervalMontantModel();
        $data['intervalles']  = $model->findAll();
        $data['pageTitle']    = 'Tranches de montant';
        $data['pageSubtitle'] = 'Côté opérateur · Base des barèmes de frais';
        $data['activeNav']    = 'interval';
        return view('interval_montant/index', $data);
    }
    public function getAll()
    {
        $model = new IntervalMontantModel();
        $data['intervalles'] = $model->findAll();
        return $data;
    }

    public function save()
    {
        $model = new IntervalMontantModel();
        $model->save([
            'debut' => $this->request->getPost('debut'),
            'fin'   => $this->request->getPost('fin')
        ]);
        return redirect()->to('/interval-montant')->with('success', 'Tranche ajoutée avec succès.');
    }
    public function save2($debut, $fin)
    {
        $model = new IntervalMontantModel();
        $model->save([
            'debut' => $debut,
            'fin'   => $fin
        ]);
        return $model->getInsertID();
    }

    public function delete($id)
    {
        $model = new IntervalMontantModel();
        $model->delete($id);
        return redirect()->to('/interval-montant')->with('success', 'Tranche supprimée.');
    }
}