<?php 
namespace App\Models;
use CodeIgniter\Model;
class EpargneModel extends Model{
    protected $table = 'epargne';
    protected $primaryKey = 'id';
    protected $allowedFieds = ['idClientNumero','valeur'];
}

?>