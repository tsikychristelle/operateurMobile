<?php

namespace App\Controllers;

class ClientController extends BaseController
{
    public function index()
    {
        return view('client/login');
    }

    public function login()
    {
        $numero = trim((string) $this->request->getPost('numero'));

        if ($numero === '') {
            return redirect()->to('/client')->with('error', 'Veuillez saisir un numéro de téléphone.');
        }

        // NOTE: l'espace client (solde, dépôt, retrait, transfert, historique)
        // n'est pas encore développé. Le login automatique par numéro sera
        // branché ici une fois clientNumeroController / mouvementController prêts.
        return redirect()->to('/client')->with('error', "Espace client en cours de construction. Numéro reçu : {$numero}.");
    }
}
