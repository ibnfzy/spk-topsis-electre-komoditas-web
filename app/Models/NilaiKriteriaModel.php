<?php

namespace App\Models;

use CodeIgniter\Model;

class NilaiKriteriaModel extends Model
{
    protected $table            = 'nilai_kriteria';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'komoditas_id',
        'kriteria_id',
        'nilai',
    ];
}
