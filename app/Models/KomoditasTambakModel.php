<?php

namespace App\Models;

use CodeIgniter\Model;

class KomoditasTambakModel extends Model
{
    protected $table            = 'komoditas_tambak';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'nama_komoditas',
        'kategori',
        'deskripsi',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
