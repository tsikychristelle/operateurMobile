<?php 
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Models\ClientNumeroSoldeModel;
use App\Controllers\clientController;
use App\Models\ClientModel;
use App\Models\ClientNumeroModel;
use App\Controllers\clientNumeroController;
use App\Controllers\clientNumeroOperateurController;
use App\Models\ClientNumeroOperateurModel;
use App\Controllers\OperateurController;
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

        $this->mouvementModel->save([
            'idClientNumero' => $idClientNumero,
            'idTypeOperation' => 1,
            'montant' => $montant,
            'idRecepteur' => $idClientNumero,
        ]);

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
            'idClientNumero' => $idClientNumeroConnecte,
            'idTypeOperation' => $fraisRow['idTypeOperation'], 
            'montant'         => $montant,
            'idEnvoyeur'      => $idClientNumeroCible,    
            'idRecepteur'     => $idClientNumeroConnecte  
        ]);

        return redirect()->to('/client-numero/solde')->with('success', "Retrait effectué avec succès !");
    }

    public function transfert(){
        return view('mouvement/transfert');
    }

   public function transfert1()
    {
        $session = session();
        $idClientNumeroConnecte = $session->get('idClientNumero');
        $clientNumeroOperateurController = new clientNumeroOperateurController();
        
        // Récupération de la chaîne de numéros et découpage en tableau
        $recepteursInput = $this->request->getPost('recepteurs');
        $numeros = array_filter(array_map('trim', explode(',', $recepteursInput)));
        
        $montantTotal = floatval($this->request->getPost('montant'));
        $avecFrais = $this->request->getPost('avecFrais') === '1';

        if (!$idClientNumeroConnecte || empty($numeros) || $montantTotal <= 0) {
            return redirect()->back()->with('error', 'Données de transaction invalides.');
        }

        // 1. VERIFICATION OPERATEUR COMMUN
        // On appelle la fonction de vérification de l'opérateur
        if (!$clientNumeroOperateurController->sameOperateurByMultipleNumbers($numeros)) {
            return redirect()->back()->with('error', 'Les numéros saisis doivent tous appartenir au même opérateur.');
        }

        $nbRecepteurs = count($numeros);
        $montantParRecepteur = $montantTotal / $nbRecepteurs; // Partage du montant

        // 2. RECHERCHE DU FRAIS APPLICABLE (basé sur le montant individuel ou total selon vos règles)
        $fraisTypeOperationModel = new \App\Models\FraisTypeOperationModel();
        $fraisRow = $fraisTypeOperationModel
            ->join('intervalMontant', 'intervalMontant.id = fraisTypeOperation.idIntervalMontant')
            ->where('fraisTypeOperation.idTypeOperation', 3)
            ->where('intervalMontant.debut <=', $montantParRecepteur)
            ->where('intervalMontant.fin >=', $montantParRecepteur)
            ->first();

        if (!$fraisRow) {
            return redirect()->back()->with('error', 'Aucun frais de transfert n’est configuré pour ce montant.');
        }

        $fraisUnitaire = floatval($fraisRow['frais']);
        $fraisTotal = $fraisUnitaire * $nbRecepteurs;
        $totalADeduire = $montantTotal + $fraisTotal;

        // 3. VÉRIFICATION DU SOLDE DE L'ENVOYEUR
        $soldeModel = new \App\Models\ClientNumeroSoldeModel();
        $soldeConnecte = $soldeModel->where('idClientNumero', $idClientNumeroConnecte)->first();

        if (!$soldeConnecte || $soldeConnecte['solde'] < $totalADeduire) {
            return redirect()->back()->with('error', "Solde insuffisant. Il faut au moins $totalADeduire Ar (Montant + Frais).");
        }

        // 4. DEBIT DU COMPTE EMETTEUR
        $soldeModel->update($soldeConnecte['id'], [
            'solde' => $soldeConnecte['solde'] - $totalADeduire
        ]);

        // 5. CREDIT ET ENREGISTREMENT DU MOUVEMENT POUR CHAQUE RECEPTEUR
        $clientNumeroModel = new \App\Models\ClientNumeroModel();

        foreach ($numeros as $numero) {
            $compteRecepteur = $clientNumeroModel->where('numero', $numero)->first();

            if ($compteRecepteur) {
                $soldeRecepteur = $soldeModel->where('idClientNumero', $compteRecepteur['id'])->first();

                if ($soldeRecepteur) {
                    $montantCredite = $avecFrais ? $montantParRecepteur + $fraisUnitaire : $montantParRecepteur;

                    // Crédit du destinataire
                    $soldeModel->update($soldeRecepteur['id'], [
                        'solde' => $soldeRecepteur['solde'] + $montantCredite
                    ]);

                    // Historisation de la transaction
                    $this->mouvementModel->save([
                        'idTypeOperation' => $fraisRow['idTypeOperation'],
                        'montant'         => $montantParRecepteur,
                        'idEnvoyeur'      => $idClientNumeroConnecte,
                        'idRecepteur'     => $compteRecepteur['id']
                    ]);
                }
            }
        }

        return redirect()->to('/client-numero/solde')->with('success', 'Transfert multiple effectué avec succès !');
    }

        

}