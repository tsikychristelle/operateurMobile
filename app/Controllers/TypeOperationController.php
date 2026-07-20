<?php

namespace App\Controllers;

use App\Models\TypeOperationModel;

class TypeOperationController extends BaseController
{
    public function index()
    {
        $model = new TypeOperationModel();
        $data['types'] = $model->findAll();
        return view('type_operation/index', $data);
    }

    public function save()
    {
        $model = new TypeOperationModel();
        $model->save(['type' => $this->request->getPost('type')]);
        return redirect()->to('/type-operation');
    }

    public function delete($id)
    {
        $model = new TypeOperationModel();
        $model->delete($id);
        return redirect()->to('/type-operation');
    }
    public function edit($id)
    {
        $model = new TypeOperationModel();
        $data['type'] = $model->find($id);
        return view('type_operation/edit', $data);
    }
    public function getAll(){
        $model = new TypeOperationModel();
        $data['types'] = $model->findAll();
       return $data;
    }
}