<?php 
namespace App\Controllers;
use App\Models\EpargneModel;
class EpargneController extends BaseController{
    protected $epargneModel;
    public function __construct(){ 
        $this->epargneModel= new EpargneModel();
    }
    public function index(){
        return view('epargne/index');
    }
    public function save(){
        $session = session();
        $idClientNumeroConnecte = $session->get('idClientNumero'); 
        $valeur = $this->request->getPost('valeur');
        $this->epargneModel->save([
            'idClientNumero' => $session->get('idClientNumero'),
            'valeur' => $this->request->getPost('valeur')
        ]);
        return redirect()->to('/client-numero/solde');
    }
    public function getAll(){
        $data['epagne']= $this->epargneModel->findAll();
        return $data;
    }
}

?>