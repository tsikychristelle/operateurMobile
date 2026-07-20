<?php 
    namespace App\Models;
    use CodeIgniter\Model;
    class ClientNumeroOperateurModel extends Model{
        protected $table = 'clientNumeroOperateur';
        protected $primaryKey = 'id';
        protected $allowedFields = ['idClientNumero', 'idOperateur'];
    }

?>