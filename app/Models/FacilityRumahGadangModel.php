<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class FacilityRumahGadangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'facility_rumah_gadang';
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
    public function get_list_fc_api() {
        $query = $this->db->table($this->table)
            ->select('id, facility')
            ->get();
        return $query;
    }
    
    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('FC%03d', $count + 1);
        return $id;
    }
    
    public function add_fc_api($facility = null) {
        foreach ($facility as $key => $value) {
            if(empty($value)) {
                unset($facility[$key]);
            }
        }
        $facility['created_at'] = Time::now();
        $facility['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($facility);
        return $insert;
    }
    
    public function update_fc_api($id = null, $facility = null) {
        foreach ($facility as $key => $value) {
            if(empty($value)) {
                unset($facility[$key]);
            }
        }
        $facility['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($facility);
        return $query;
    }
}
