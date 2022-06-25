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
    protected $allowedFields    = ['id', 'name', 'address', 'contact_person', 'capacity', 'open', 'close', 'employee', 'geom', 'owner', 'lat', 'long', 'description'];

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
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'culinary_place.owner = account.id')
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
        $query = $this->db->table($this->table)
            ->select('culinary_place.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('culinary_place.id', $id)
            ->join('account', 'culinary_place.owner = account.id')
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

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
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
