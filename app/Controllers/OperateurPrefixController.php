<?php

namespace App\Controllers;

use App\Models\OperateurPrefixModel;

class OperateurPrefixController extends BaseController
{
    public function index()
    {
        $model = new OperateurPrefixModel();
        $data['prefixes'] = $model->findAll();
        return view('operateur_prefix/index', $data);
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