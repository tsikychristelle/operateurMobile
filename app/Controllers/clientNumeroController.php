<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Controllers\clientController;
use App\Models\ClientNumeroSoldeModel;
use App\Models\ClientModel;
use App\Models\ClientNumeroModel;
class clientNumeroController extends  BaseController{
    protected $clientNumeroModel;
    protected $mouvementModel;

    public function __construct(){  
        $this->clientNumeroModel = new ClientNumeroModel();
        $this->mouvementModel = new MouvementModel();
    }
    // protected $mouvementModel;
    // public function __construct(){  
    //     $this->mouvementModel = new MouvementModel();
    // }
  
    public function index(){
        // $data['mouvements'] = $this->mouvementModel->findAll();
        $data['pageTitle'] = 'Solde du client';
        $data['pageSubtitle'] = 'Consultation du compte';
        $data['activeNav'] = 'client-solde';
        $data['viewMode'] = 'client';
        return view('clientNumero/index');
    }
    // public function save(){
    //     $this->mouvementModel->save([
    //         'idClientNumero' => $this->request->getPost('idClientNumero'),
    //         'solde' => $this->request->getPost('solde')
    //     ]);
    //     return redirect()->to('/clientNumeroSolde');
    // }
    // public function delete($id){
    //     $this->mouvementModel->delete($id);
    //     return redirect()->to('/clientNumeroSolde');
    // }
    // public function edit($id){
    //     $data['mouvements'] = $this->mouvementModel->find($id);
    //     return view('clientNumero/edit', $data);
    // }
    // public function update($id){
    //     $this->mouvementModel->update($id, [
    //         'idClientNumero' => $this->request->getPost('idClientNumero'),
    //         'solde' => $this->request->getPost('solde')
    //     ]);
    //     return redirect()->to('/clientNumeroSolde');    
    // }
    private function getMouvementsClient()
    {
        $session = session();
        $idClientNumero = $session->get('idClientNumero');

        if (!$idClientNumero) {
            return [];
        }

        return $this->mouvementModel
            ->select('mouvement.*, typeOperation.type as typeOperation, envoyeur.numero as numeroEnvoyeur, recepteur.numero as numeroRecepteur')
            ->join('typeOperation', 'typeOperation.id = mouvement.idTypeOperation', 'left')
            ->join('clientNumero as envoyeur', 'envoyeur.id = mouvement.idEnvoyeur', 'left')
            ->join('clientNumero as recepteur', 'recepteur.id = mouvement.idRecepteur', 'left')
            ->where('mouvement.idEnvoyeur', $idClientNumero)
            ->orWhere('mouvement.idRecepteur', $idClientNumero)
            ->orderBy('mouvement.date', 'DESC')
            ->findAll();
    }

    public function getClientByNumero($numero){
        $client = $this->clientNumeroModel->where('numero', $numero)->first();
        return $client;
    }
    public function login(){
        $session = session();
        $numero = $this->request->getPost('numero');
        $nom = $this->request->getPost('nom');
        
        $clientController = new clientController();
        $nomClient = $clientController->getClientByNom($nom);
       
        if($nomClient){
           $clientNumero = $this->getClientByNumero($numero);
            $session->set('idClientNumero', $clientNumero['id']);
            $session->set('idClient',$nomClient['id']);
            if($clientNumero && $clientNumero['idClient'] == $nomClient['id']){
                // Successful login
                            return view("clientNumero/accueil", [
                'pageTitle' => 'Accueil client',
                'pageSubtitle' => 'Bienvenue dans votre espace',
                'activeNav' => '',
                'viewMode' => 'client',
                'mouvements' => $this->getMouvementsClient(),
            ]);
            } else {
                // Handle failed login
                return redirect()->to('/login');
            }
        } else {
            // Handle failed login
            return redirect()->to('/login');
        }
    }
   public function accueil(){
    return view("clientNumero/accueil", [
        'pageTitle' => 'Accueil client',
        'pageSubtitle' => 'Bienvenue dans votre espace',
        'activeNav' => '',
        'viewMode' => 'client',
        'mouvements' => $this->getMouvementsClient(),
    ]);
}

}
