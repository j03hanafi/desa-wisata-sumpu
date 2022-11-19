<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitHistoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'visit_history';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'user_id', 'date_visit', 'category', 'object_id'];

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
    public function get_new_id_api() {
        $lastId = $this->db->table($this->table)->select('id')->orderBy('id', 'ASC')->get()->getLastRow('array');
        $count = (int)substr($lastId['id'], 0);
        $id = sprintf('%03d', $count + 1);
        return $id;
    }

    public function get_visit_history_by_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('visit_history.*')
            ->where('user_id', $id)
            ->orderBy('date_visit', 'DESC')
            ->get();
        return $query;
    }

    public function get_visited_object_api($list_data = null) {
        $new_data = array();
        foreach ($list_data as $data) {
            if ($data['category'] == '1') {
                $query = $this->db->table('rumah_gadang')
                    ->select('name')
                    ->where('id', $data['object_id'])
                    ->get()->getRowArray();
                $data['object_name'] = $query['name'];
            } elseif ($data['category'] == '2') {
                $query = $this->db->table('event')
                    ->select('name')
                    ->where('id', $data['object_id'])
                    ->get()->getRowArray();
                $data['object_name'] = $query['name'];
            }
            $new_data[] = $data;
        }

        return $new_data;
    }
}
