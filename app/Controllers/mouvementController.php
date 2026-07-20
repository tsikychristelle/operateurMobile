<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Models\ClientNumeroSoldeModel;
class mouvementController extends  BaseController{
    protected $mouvementModel;
    protected $clientNumeroSoldeModel;
    public function __construct(){  
        $this->mouvementModel = new MouvementModel();
        $this->clientNumeroSoldeModel = new ClientNumeroSoldeModel();
    }
    public function index(){
        $data['mouvements'] = $this->mouvementModel->findAll();
        return view('mouvement/index', $data);
    }
    public function depot()
    {
        $session = session();
        $idClientNumero = $session->get('idClientNumero');

        if (!$idClientNumero) {
            return redirect()->to('/client')->with('error', 'Veuillez vous connecter.');
        }

        $clientSolde = $this->clientNumeroSoldeModel->where('idClientNumero', $idClientNumero)->first();

        return view('mouvement/depot', [
            'pageTitle' => 'Dépôt',
            'pageSubtitle' => 'Ajoutez de l’argent sur votre compte',
            'activeNav' => 'client-depot',
            'viewMode' => 'client',
            'currentSolde' => $clientSolde['solde'] ?? 0,
        ]);
    }

    public function saveDepot()
    {
        $session = session();
        $idClientNumero = $session->get('idClientNumero');

        if (!$idClientNumero) {
            return redirect()->to('/client')->with('error', 'Veuillez vous connecter.');
        }

        $montant = (float) str_replace(',', '.', $this->request->getPost('montant'));

        if ($montant <= 0) {
            return redirect()->back()->with('error', 'Veuillez saisir un montant de dépôt valide.');
        }

        $clientSolde = $this->clientNumeroSoldeModel->where('idClientNumero', $idClientNumero)->first();

        if ($clientSolde) {
            $nouveauSolde = ($clientSolde['solde'] ?? 0) + $montant;
            $this->clientNumeroSoldeModel->update($clientSolde['id'], ['solde' => $nouveauSolde]);
        } else {
            $this->clientNumeroSoldeModel->insert([
                'idClientNumero' => $idClientNumero,
                'solde' => $montant,
            ]);
        }

        return redirect()->to('/client-numero/solde')->with('message', 'Dépôt effectué avec succès.');
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