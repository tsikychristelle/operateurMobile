<?php
namespace App\Controllers;
use App\Models\MouvementModel;
use App\Models\ClientNumeroModel;
use App\Models\ClientNumeroOperateurModel;
class clientNumeroOperateurController extends BaseController{
    protected $clientNumeroOperateurModel;
    protected $mouvementModel;
    public function __construct(){  
        $this->clientNumeroOperateurModel = new ClientNumeroOperateurModel();
        $this->mouvementModel = new MouvementModel();
    }
    public function sameOperateurByTwoNumber($numero1,$numero2){
        $clientNumeroModel = new ClientNumeroModel();
        $clientNumero1 = $clientNumeroModel->where('numero',$numero1)->first();
        $clientNumero2 = $clientNumeroModel->where('numero',$numero2)->first();
        $clientNumer1Operateur = $this->clientNumeroOperateurModel->where('idClientNumero',$clientNumero1['id'])->first();
        $clientNumer2Operateur = $this->clientNumeroOperateurModel->where('idClientNumero',$clientNumero2['id'])->first();
        if($clientNumer1Operateur['idOperateur'] == $clientNumer2Operateur['idOperateur']){
            return true;
        }else{
            return false;
        }
    }
    public function sameOperateurByMultipleNumbers(array $numeros)
    {
        $clientNumeroModel = new ClientNumeroModel();
        // S'il y a moins de 2 numéros, ils sont considérés comme du même opérateur par défaut
        if (count($numeros) < 2) {
            return true;
        }

        $firstOperateurId = null;

        foreach ($numeros as $numero) {
            // 1. Récupérer l'enregistrement du numéro
            $clientNumero = $clientNumeroModel->where('numero', $numero)->first();

            // Si un numéro n'existe pas dans la base, on ne peut pas comparer
            if (!$clientNumero) {
                return false; 
            }

            // 2. Récupérer l'opérateur associé
            $clientNumeroOperateur = $this->clientNumeroOperateurModel
                ->where('idClientNumero', $clientNumero['id'])
                ->first();

            if (!$clientNumeroOperateur) {
                return false;
            }

            $currentOperateurId = $clientNumeroOperateur['idOperateur'];

            // 3. Pour le premier numéro, on enregistre son opérateur
            if ($firstOperateurId === null) {
                $firstOperateurId = $currentOperateurId;
            } 
            // Pour les suivants, on compare avec le premier
            elseif ($currentOperateurId !== $firstOperateurId) {
                return false; // Dès qu'un opérateur diffère, on arrête et retourne false
            }
        }

        // Si la boucle s'est terminée sans différence, ils ont tous le même opérateur
        return true;
    }
}


?>