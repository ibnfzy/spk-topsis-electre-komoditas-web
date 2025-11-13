<?php

namespace App\Models;

use CodeIgniter\Model;

class PerbandinganMetodeModel extends Model
{
    protected $table            = 'perbandingan_metode';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'rho_spearman',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
}
