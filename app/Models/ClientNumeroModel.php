<?php
    namespace App\Models;
    use CodeIgniter\Model;
    class ClientNumeroModel extends Model{
        protected $table = 'clientNumero';
        protected $primaryKey = 'id';
        protected $allowedFields = ['idClient', 'numero'];
        

}