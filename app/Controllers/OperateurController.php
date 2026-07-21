<?php

namespace App\Controllers;

use App\Models\OperateurModel;
use App\Models\OperateurPrefixModel;

class OperateurController extends BaseController
{
    public function index()
    {
        $model = new OperateurModel();
        $data['operateurs']   = $model->findAll();
        $data['pageTitle']    = 'Opérateurs';
        $data['pageSubtitle'] = 'Côté opérateur · Configuration';
        $data['activeNav']    = 'operateur';
        return view('operateur/index', $data);
    }

    public function save()
    {
        $model = new OperateurModel();
        $model->save([
            'libelle' => $this->request->getPost('libelle')
        ]);

        return redirect()->to('/operateur')->with('success', 'Opérateur ajouté avec succès.');
    }

    public function delete($id)
    {
        $model = new OperateurModel();
        $model->delete($id);
        return redirect()->to('/operateur')->with('success', 'Opérateur supprimé.');
    }
    
    public function getOperateurByNumero(string $numero)
    {
        $model = new OperateurPrefixModel();
        $prefix = substr($numero, 0, 3);

        return $model
            ->join('operateur', 'operateur.id = operateurPrefix.idOperateur')
            ->where('prefix', $prefix)
            ->first();
    }
}