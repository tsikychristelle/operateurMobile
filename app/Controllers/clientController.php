<?php 
namespace App\Controllers;
use App\Models\ClientModel;
use App\Models\ClientNumeroModel;
use App\Models\ClientNumeroOperateurModel;
use App\Models\ClientNumeroSoldeModel;
class clientsController extends BaseController{
    protected $clientModel;
    public function __construct(){  
        $this->clientModel = new ClientModel();
    }
    public function index(){
        $data['clients'] = $this->clientModel->findAll();
        return view('client/index', $data);
    }
       
    public function save(){
       
        $this->clientModel->save([
            'idClientNumero' => $this->request->getPost('idClientNumero'),
            'solde' => $this->request->getPost('solde')
        ]);
        return redirect()->to('/mouvement');
    }
    public function delete($id){
        $this->clientModel->delete($id);
        return redirect()->to('/mouvement');   
    }
    public function edit($id){
        $clientNumeroSoldeModel = new ClientNumeroSoldeModel();
        $data['clientNumeroSolde'] = $clientNumeroSoldeModel->find($id);
        return view('mouvement/edit', $data);
    }
    public function update($id){
        $clientNumeroSoldeModel = new ClientNumeroSoldeModel();
        $clientNumeroSoldeModel->update($id, [
            'idClientNumero' => $this->request->getPost('idClientNumero'),
            'solde' => $this->request->getPost('solde')
        ]);
        return redirect()->to('/mouvement');    
    }
}
?>