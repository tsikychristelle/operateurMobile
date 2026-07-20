<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Models\ClientNumeroSoldeModel;
use App\Controllers\clientController;
use App\Models\ClientModel;
use App\Models\ClientNumeroModel;
use App\Controllers\clientNumeroController;
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