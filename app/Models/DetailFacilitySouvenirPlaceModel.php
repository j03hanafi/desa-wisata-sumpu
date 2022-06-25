<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class DetailFacilitySouvenirPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_facility_souvenir_place';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'souvenir_place_id', 'facility_id'];

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
    public function get_facility_by_id_api($souvenir_place_id = null) {
        $query = $this->db->table($this->table)
            ->select('facility_souvenir_place.facility')
            ->where('souvenir_place_id', $souvenir_place_id)
            ->join('facility_souvenir_place', 'detail_facility_souvenir_place.facility_id = facility_souvenir_place.id')
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
                'souvenir_place_id' => $id,
                'facility_id' => $facility,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_facility_api($id = null, $data = null) {
        $queryDel = $this->db->table($this->table)->delete(['souvenir_place_id' => $id]);
        $queryIns = $this->add_facility_api($id, $data);
        return $queryDel && $queryIns;
    }
}
