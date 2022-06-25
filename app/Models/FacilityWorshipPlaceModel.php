<?php

namespace App\Models;

use CodeIgniter\Model;

class FacilityWorshipPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'facility_worship_place';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'facility'];

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

}
