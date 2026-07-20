<?php 
    namespace App\Models;
    use CodeIgniter\Model;
    class FraisTypeOperationModel extends Model{
        protected $table = 'fraisTypeOperation';
        protected $primaryKey = 'id';
        protected $allowedFields = ['idTypeOperation', 'idIntervalMontant', 'frais'];
    }


?>