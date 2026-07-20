<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Controllers\clientController;
use App\Models\ClientNumeroSoldeModel;
use App\Models\ClientModel;
use App\Models\ClientNumeroModel;
use App\Controllers\clientNumeroController;
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
    public function retrait(){
        return view('mouvement/retrait');
    }
   
    public function retrait1()
    {
        $session = session();
        $idClientNumeroConnecte = $session->get('idClientNumero'); 
        
        // 1. On récupère le NUMÉRO écrit dans l'input (et non un ID)
        $numeroRecepteurSaisi = $this->request->getPost('recepteur');   
        $montant = floatval($this->request->getPost('montant'));

        if (!$idClientNumeroConnecte || !$numeroRecepteurSaisi || $montant <= 0) {
            return redirect()->back()->with('error', 'Données de transaction invalides.');
        }

        // 2. CORRECTION RECHERCHE : On cherche la ligne correspondant à ce numéro de téléphone
        $clientNumeroModel = new \App\Models\ClientNumeroModel();
        $compteCible = $clientNumeroModel->where('numero', $numeroRecepteurSaisi)->first();

        if (!$compteCible) {
            return redirect()->back()->with('error', "Le numéro destinataire '$numeroRecepteurSaisi' n'existe pas.");
        }

        // On extrait le véritable ID de la base de données
        $idClientNumeroCible = $compteCible['id'];

        // 3. RECHERCHE DU FRAIS APPLICABLE
        $fraisTypeOperationModel = new \App\Models\FraisTypeOperationModel();
        $fraisRow = $fraisTypeOperationModel
            ->join('intervalMontant', 'intervalMontant.id = fraisTypeOperation.idIntervalMontant')
            ->where('fraisTypeOperation.idTypeOperation', 2)
            ->where('intervalMontant.debut <=', $montant)
            ->where('intervalMontant.fin >=', $montant)
            ->first();

        if (!$fraisRow) {
            $fraisRow = $fraisTypeOperationModel
                ->select('fraisTypeOperation.*')
                ->join('intervalMontant', 'intervalMontant.id = fraisTypeOperation.idIntervalMontant')
                ->where('fraisTypeOperation.idTypeOperation', 2)
                ->where('intervalMontant.fin <=', $montant)
                ->orderBy('intervalMontant.fin', 'DESC')
                ->first();
        }

        if (!$fraisRow) {
            $fraisRow = $fraisTypeOperationModel
                ->select('fraisTypeOperation.*')
                ->join('intervalMontant', 'intervalMontant.id = fraisTypeOperation.idIntervalMontant')
                ->where('fraisTypeOperation.idTypeOperation', 2)
                ->orderBy('intervalMontant.debut', 'ASC')
                ->first();
        }

        if (!$fraisRow) {
            return redirect()->back()->with('error', 'Aucun frais de retrait n’est configuré.');
        }

        $frais = floatval($fraisRow['frais']);
        $totalADeduire = $montant + $frais;

        // 4. VÉRIFICATION ET RECHERCHE DES SOLDES
        $soldeModel = new \App\Models\ClientNumeroSoldeModel();
        
        $soldeConnecte = $soldeModel->where('idClientNumero', $idClientNumeroConnecte)->first();
        $soldeCible    = $soldeModel->where('idClientNumero', $idClientNumeroCible)->first();

        if (!$soldeCible) {
            return redirect()->back()->with('error', 'Le compte sélectionné ne possède pas de solde actif.');
        }

        if (!$soldeConnecte) {
            return redirect()->back()->with('error', 'Le compte du client connecté ne possède pas de solde actif.');
        }

        if ($soldeCible['solde'] < $totalADeduire) {
            return redirect()->back()->with('error', "Solde insuffisant sur ce compte. Il faut au moins $totalADeduire Ar.");
        }

        // 5. MISE À JOUR DES SOLDES
        $soldeModel->update($soldeCible['id'], [
            'solde' => $soldeCible['solde'] - $totalADeduire
        ]);

        if ($soldeConnecte) {
            $soldeModel->update($soldeConnecte['id'], [
                'solde' => $soldeConnecte['solde'] + $montant
            ]);
        } else {
            $soldeModel->save([
                'idClientNumero' => $idClientNumeroConnecte,
                'solde'          => $montant
            ]);
        }

        // 6. ENREGISTREMENT DU MOUVEMENT
        $this->mouvementModel->save([
            'idTypeOperation' => $fraisRow['idTypeOperation'], 
            'montant'         => $montant,
            'idEnvoyeur'      => $idClientNumeroCible,    
            'idRecepteur'     => $idClientNumeroConnecte  
        ]);

        return redirect()->to('/client-numero/solde')->with('success', "Retrait effectué avec succès !");
    }

        

}