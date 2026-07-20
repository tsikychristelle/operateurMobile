<?php

namespace App\Controllers;

use App\Models\OperateurPrefixModel;
use App\Models\OperateurModel;

class OperateurPrefixController extends BaseController
{
    public function index()
    {
        $prefixModel = new OperateurPrefixModel();
        $operateurModel = new OperateurModel();
        $myOperateurId = defined('MY_OPERATEUR_ID') ? MY_OPERATEUR_ID : null;
        $myOperateurLibelle = defined('MY_OPERATEUR_LIBELLE') ? MY_OPERATEUR_LIBELLE : null;

        $data['myOperateur'] = null;

        if ($myOperateurId) {
            $data['myOperateur'] = $operateurModel->find($myOperateurId);
        }

        if (! $data['myOperateur'] && $myOperateurLibelle) {
            $data['myOperateur'] = $operateurModel->where('libelle', $myOperateurLibelle)->first();
        }

        if (! $data['myOperateur'] && $myOperateurLibelle) {
            $operateurModel->insert(['libelle' => $myOperateurLibelle]);
            $data['myOperateur'] = $operateurModel->find($operateurModel->insertID());
        }

        if (! $data['myOperateur']) {
            $data['myOperateur'] = $operateurModel->orderBy('id', 'ASC')->first();
        }

        $myOperateurId = $data['myOperateur']['id'] ?? null;

        $data['myPrefixes'] = $myOperateurId
            ? $prefixModel->select('operateurPrefix.*')->where('idOperateur', $myOperateurId)->findAll()
            : [];

        $data['otherPrefixes'] = $prefixModel
            ->select('operateurPrefix.*, operateur.libelle')
            ->join('operateur', 'operateur.id = operateurPrefix.idOperateur')
            ->where('operateur.id !=', $myOperateurId)
            ->findAll();

        $data['otherOperateurs'] = $operateurModel->where('id !=', $myOperateurId)->findAll();

        $data['pageTitle']    = 'Préfixes';
        $data['pageSubtitle'] = 'Côté opérateur · Configuration des préfixes';
        $data['activeNav']    = 'prefix';

        return view('operateurPRefix/index', $data);
    }
 
    public function save()
    {
        $idOperateur = (int) $this->request->getPost('idOperateur');
        $prefix = trim((string) $this->request->getPost('prefix'));

        $operateurModel = new OperateurModel();
        $operateur = $operateurModel->find($idOperateur);

        if (! $operateur) {
            return redirect()->back()->with('error', 'Opérateur invalide ou inexistant.');
        }

        if ($prefix === '') {
            return redirect()->back()->with('error', 'Veuillez saisir un préfixe valide.');
        }

        $model = new OperateurPrefixModel();
        $model->save([
            'idOperateur' => $idOperateur,
            'prefix'      => $prefix,
        ]);

        return redirect()->to('/operateur-prefix')->with('success', 'Préfixe ajouté avec succès.');
    }

    public function delete($id)
    {
        $model = new OperateurPrefixModel();
        $model->delete($id);
        return redirect()->to('/operateur-prefix')->with('success', 'Préfixe supprimé.');
    }
}