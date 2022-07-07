<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryEventModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'category_event';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'category'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // API
    public function get_list_cat_api() {
        $query = $this->db->table($this->table)
            ->select('id, category')
            ->get();
        return $query;
    }
}
