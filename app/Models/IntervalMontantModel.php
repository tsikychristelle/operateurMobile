<?php

namespace App\Models;

use CodeIgniter\Model;

class IntervalMontantModel extends Model
{
    protected $table            = 'intervalMontant';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['debut', 'fin'];

    protected $useTimestamps = false;

   
}