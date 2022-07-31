<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class CulinaryPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'culinary_place';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'contact_person', 'capacity', 'open', 'close', 'employee', 'geom', 'description'];

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
    public function get_list_cp_api() {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.contact_person,{$this->table}.capacity,{$this->table}.open,{$this->table}.close,{$this->table}.employee,{$this->table}.description";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function list_by_owner($id = null) {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('owner', $id)
            ->join('account', 'culinary_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_cp_by_id_api($id = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.contact_person,{$this->table}.capacity,{$this->table}.open,{$this->table}.close,{$this->table}.employee,{$this->table}.description";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->where('culinary_place.id', $id)
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function get_cp_in_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->whereIn('culinary_place.id', $id)
            ->join('account', 'culinary_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_cp_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'culinary_place.owner = account.id')
            ->like('name', $name)
            ->get();
        return $query;
    }
    
    public function get_cp_by_radius_api($data = null) {
        $radius = (int)$data['radius'] / 1000;
        $lat = $data['lat'];
        $long = $data['long'];
        $jarak = "(6371 * acos(cos(radians({$lat})) * cos(radians(ST_Y(ST_CENTROID({$this->table}.geom)))) * cos(radians(ST_X(ST_CENTROID({$this->table}.geom))) - radians({$long})) + sin(radians({$lat}))* sin(radians(ST_Y(ST_CENTROID({$this->table}.geom))))))";
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.contact_person,{$this->table}.capacity,{$this->table}.open,{$this->table}.close,{$this->table}.employee,{$this->table}.description";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}, {$jarak} as jarak")
            ->from('village')
            ->where($vilGeom)
            ->having(['jarak <=' => $radius])
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        $count = (int)substr($lastId['id'], 2);
        $id = sprintf('CP%03d', $count + 1);
        return $id;
    }

    public function add_cp_api($culinary_place = null) {
        foreach ($culinary_place as $key => $value) {
            if(empty($value)) {
                unset($culinary_place[$key]);
            }
        }
        $culinary_place['created_at'] = Time::now();
        $culinary_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($culinary_place);
        return $query;
    }

    public function update_cp_api($id = null, $culinary_place = null) {
        foreach ($culinary_place as $key => $value) {
            if(empty($value)) {
                unset($culinary_place[$key]);
            }
        }
        $culinary_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($culinary_place);
        return $query;
    }
}
