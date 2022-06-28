<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class DetailFacilityRumahGadangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_facility_rumah_gadang';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'rumah_gadang_id', 'facility_id'];

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
    public function get_facility_by_id_api($rumah_gadang_id = null) {
        $query = $this->db->table($this->table)
            ->select('facility_rumah_gadang.facility')
            ->where('rumah_gadang_id', $rumah_gadang_id)
            ->join('facility_rumah_gadang', 'detail_facility_rumah_gadang.facility_id = facility_rumah_gadang.id')
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('DFC%03d', $count + 1);
        return $id;
    }

    public function add_facility_api($id = null, $data = null) {
        $query = false;
        foreach ($data as $facility) {
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'rumah_gadang_id' => $id,
                'facility_id' => $facility,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_facility_api($id = null, $data = null) {
        $queryDel = $this->db->table($this->table)->delete(['rumah_gadang_id' => $id]);
        $queryIns = $this->add_facility_api($id, $data);
        return $queryDel && $queryIns;
    }
}