<?php

namespace App\Controllers;

use App\Models\TypeOperationModel;

class TypeOperationController extends BaseController
{
    public function index()
    {
        $model = new TypeOperationModel();
        $data['types']        = $model->findAll();
        $data['pageTitle']    = "Types d'opération";
        $data['pageSubtitle'] = 'Côté opérateur · Dépôt, retrait, transfert';
        $data['activeNav']    = 'type';
        return view('type_operation/index', $data);
    }

    public function save()
    {
        $model = new TypeOperationModel();
        $model->save(['type' => $this->request->getPost('type')]);
        return redirect()->to('/type-operation')->with('success', "Type d'opération ajouté avec succès.");
    }

    public function delete($id)
    {
        $model = new TypeOperationModel();
        $model->delete($id);
        return redirect()->to('/type-operation')->with('success', 'Type supprimé.');
    }
}