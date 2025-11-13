<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilElectreModel extends Model
{
    protected $table            = 'hasil_electre';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'komoditas_id',
        'nilai_akhir',
        'ranking',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
}
