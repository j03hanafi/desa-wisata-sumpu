<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class WorshipPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'worship_place';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'park_area_size', 'building_size', 'capacity', 'last_renovation', 'geom', 'category_id', 'owner', 'lat', 'long', 'description'];

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
    public function get_list_wp_api() {
        $query = $this->db->table($this->table)
            ->select('worship_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'worship_place.owner = account.id')
            ->get();
        return $query;
    }

    public function list_by_owner_api($id) {
        $query = $this->db->table($this->table)
            ->select('worship_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('owner', $id)
            ->join('account', 'worship_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_wp_by_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('worship_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('worship_place.id', $id)
            ->join('account', 'worship_place.owner = account.id')
            ->get();
        return $query;
    }

    public function get_wp_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('worship_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'worship_place.owner = account.id')
            ->like('name', $name)
            ->get();
        return $query;
    }

    public function get_wp_by_category_api($category_id = null) {
        $query = $this->db->table($this->table)
            ->select('worship_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'worship_place.owner = account.id')
            ->like('category_id', $category_id)
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('WP%03d', $count + 1);
        return $id;
    }

    public function add_wp_api($worship_place = null) {
        foreach ($worship_place as $key => $value) {
            if(empty($value)) {
                unset($worship_place[$key]);
            }
        }
        $worship_place['created_at'] = Time::now();
        $worship_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($worship_place);
        return $query;
    }

    public function update_wp_api($id = null, $worship_place = null) {
        foreach ($worship_place as $key => $value) {
            if(empty($value)) {
                unset($worship_place[$key]);
            }
        }
        $worship_place['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($worship_place);
        return $query;
    }
}
