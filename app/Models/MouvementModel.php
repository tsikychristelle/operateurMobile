<?php 
namespace App\Models;
use CodeIgniter\Model;
class ClientNumeroSoldeModel extends Model{
    protected $table = 'clientNumeroSolde';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idClientNumero', 'solde'];
}

?>