<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class RumahGadangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rumah_gadang';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'open', 'close', 'ticket_price', 'geom', 'contact_person', 'recom', 'owner', 'lat', 'long', 'description'];

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
    public function get_recommendation_api() {
        $query = $this->db->table($this->table)
            ->select('rumah_gadang.*, recommendation.name as recommendation, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('recom', 'REC01')
            ->join('recommendation', 'rumah_gadang.recom = recommendation.id')
            ->join('account', 'rumah_gadang.owner = account.id')
            ->get();
        return $query;
    }

    public function recommendation_by_owner_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('rumah_gadang.*, recommendation.name as recommendation, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('recom', 'REC01')
            ->where('owner', $id)
            ->join('recommendation', 'rumah_gadang.recom = recommendation.id')
            ->join('account', 'rumah_gadang.owner = account.id')
            ->get();
        return $query;
    }

    public function get_list_rg_api() {
        $query = $this->db->table($this->table)
            ->select('rumah_gadang.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'rumah_gadang.owner = account.id')
            ->get();
        return $query;
    }

    public function list_by_owner_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('rumah_gadang.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'rumah_gadang.owner = account.id')
            ->where('owner', $id)
            ->get();
        return $query;
    }

    public function get_rg_by_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('rumah_gadang.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('rumah_gadang.id', $id)
            ->join('account', 'rumah_gadang.owner = account.id')
            ->get();
        return $query;
    }

    public function get_rg_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('rumah_gadang.*, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('account', 'rumah_gadang.owner = account.id')
            ->like('name', $name)
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('RG%03d', $count + 1);
        return $id;
    }

    public function add_rg_api($rumah_gadang = null) {
        foreach ($rumah_gadang as $key => $value) {
            if(empty($value)) {
                unset($rumah_gadang[$key]);
            }
        }
        $rumah_gadang['created_at'] = Time::now();
        $rumah_gadang['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($rumah_gadang);
        return $query;
    }

    public function update_rg_api($id = null, $rumah_gadang = null) {
        foreach ($rumah_gadang as $key => $value) {
            if(empty($value)) {
                unset($rumah_gadang[$key]);
            }
        }
        $rumah_gadang['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($rumah_gadang);
        return $query;
    }

    public function update_recom_api($data = null) {
        $query = false;
        foreach ($data as $recom) {
            $recomArr = (array)$recom;
            $rumah_gadang['recom'] = $recomArr['recom'];
            $rumah_gadang['updated_at'] = Time::now();

            $query = $this->db->table($this->table)
                ->where('id', $recomArr['id'])
                ->update($rumah_gadang);
        }
        return $query;
    }

}
