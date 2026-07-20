<?php 
namespace App\Models;
use CodeIgniter\Model;
class MouvementModel extends Model{
    protected $table = 'mouvement';
    protected $primaryKey = 'id';

    protected $allowedFields = [ 'date','idClientNumero','idTypeOperation', 'montant', 'idEnvoyeur', 'idRecepteur'];

}
