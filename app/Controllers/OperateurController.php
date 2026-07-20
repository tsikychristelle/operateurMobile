<?php

namespace App\Controllers;

use App\Models\OperateurModel;

class OperateurController extends BaseController
{
    public function index()
    {
        $model = new OperateurModel();
        $data['operateurs'] = $model->findAll();
        return view('operateur/index', $data);
    }

    public function save()
    {
        $model = new OperateurModel();
        $model->save([
            'libelle' => $this->request->getPost('libelle')
        ]);

        return redirect()->to('/operateur');
    }

    public function delete($id)
    {
        $model = new OperateurModel();
        $model->delete($id);
        return redirect()->to('/operateur');
    }
}