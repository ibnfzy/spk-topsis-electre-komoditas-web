<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilTopsisModel extends Model
{
    protected $table            = 'hasil_topsis';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'komoditas_id',
        'nilai_pref',
        'ranking',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;
}
