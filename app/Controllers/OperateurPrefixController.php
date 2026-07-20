<?php

namespace App\Controllers;

use App\Models\OperateurPrefixModel;
use App\Models\OperateurModel;

class OperateurPrefixController extends BaseController
{
    public function index()
    {
        $prefixModel = new OperateurPrefixModel();
        $operateurModel = new OperateurModel();

        $data['prefixes'] = $prefixModel
            ->select('operateurPrefix.*, operateur.libelle')
            ->join('operateur', 'operateur.id = operateurPrefix.idOperateur')
            ->findAll();

        $data['operateurs'] = $operateurModel->findAll();

        return view('operateurPRefix/index', $data);
    }
 
    public function save()
    {
        $model = new OperateurPrefixModel();
        $model->save([
            'idOperateur' => $this->request->getPost('idOperateur'),
            'prefix'      => $this->request->getPost('prefix')
        ]);

        return redirect()->to('/operateur-prefix');
    }

    public function delete($id)
    {
        $model = new OperateurPrefixModel();
        $model->delete($id);
        return redirect()->to('/operateur-prefix');
    }
}