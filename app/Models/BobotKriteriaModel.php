<?php

namespace App\Models;

use CodeIgniter\Model;

class BobotKriteriaModel extends Model
{
    protected $table            = 'bobot_kriteria';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'kriteria_id',
        'bobot',
    ];
}
