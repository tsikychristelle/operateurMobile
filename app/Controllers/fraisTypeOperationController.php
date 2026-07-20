<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Models\FraisTypeOperationModel;
use App\Models\TypeOperationModel;
use App\Controllers\IntervalMontantController;

class fraisTypeOperationController extends  BaseController{
    protected $fraisTypeOperationModel;



    public function __construct(){  
        $this->fraisTypeOperationModel = new FraisTypeOperationModel();
    }
    public function index(){
        $typeOperationModel = new TypeOperationModel();
        $data['types'] = $typeOperationModel->findAll();
    
        return view('fraisTypeOperation/index', $data);
    }
    public function save(){
        $data['idTypeOperation'] = $this->request->getPost('typeOperation');
       
        $intervalMontantController = new IntervalMontantController();
        $intervalMontant = $intervalMontantController->save2($this->request->getPost('debut'), $this->request->getPost('fin'));
        while ($data['idTypeOperation'] !=1) {
              $this->fraisTypeOperationModel->save([
            'idTypeOperation' => $data['idTypeOperation'],
            'idIntervalMontant' => $intervalMontant,
            'frais'=> $this->request->getPost('frais')
        ]);
        }
      
        
        return redirect()->to('/frais-type-operation');
    }
}