<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
class mouvementController extends  BaseController{
    protected $mouvementModel;
    public function __construct(){  
        $this->mouvementModel = new MouvementModel();
    }
    public function index(){
        $data['mouvements'] = $this->mouvementModel->findAll();
        return view('mouvement/index', $data);
    }
    public function save(){
        $this->mouvementModel->save([
            'idClientNumero' => $this->request->getPost('idClientNumero'),
            'solde' => $this->request->getPost('solde')
        ]);
        return redirect()->to('/clientNumeroSolde');
    }
    public function delete($id){
        $this->mouvementModel->delete($id);
        return redirect()->to('/clientNumeroSolde');
    }
    public function edit($id){
        $data['mouvements'] = $this->mouvementModel->find($id);
        return view('mouvement/edit', $data);
    }
    public function update($id){
        $this->mouvementModel->update($id, [
            'idClientNumero' => $this->request->getPost('idClientNumero'),
            'solde' => $this->request->getPost('solde')
        ]);
        return redirect()->to('/clientNumeroSolde');    
    }

}