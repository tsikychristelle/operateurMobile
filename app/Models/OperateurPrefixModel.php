<?php

namespace App\Models;

use CodeIgniter\Model;

class OperateurPrefixModel extends Model
{
    protected $table            = 'operateurPrefix';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idOperateur', 'prefix'];

    protected $useTimestamps = false;

}