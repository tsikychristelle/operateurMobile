<?php 
namespace App\Controllers;

use App\Models\ClientNumeroSoldeModel;

class clientNumeroSoldeController extends BaseController {
    protected $clientNumeroSoldeModel;

    public function __construct(){  
        $this->clientNumeroSoldeModel = new ClientNumeroSoldeModel();
    }

    public function index(){
        $session = session();
        $idClientNumero = $session->get('idClientNumero');

        // Sécurité : Si la session est vide, on redirige vers le login
        if (!$idClientNumero) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter.');
        }

        $data['clientNumeroSoldes'] = $this->clientNumeroSoldeModel
                                          ->where('idClientNumero', $idClientNumero)
                                          ->first();

        return view('clientNumeroSolde/index', $data);
    }
}