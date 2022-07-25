<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class GalleryWorshipPlaceModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'gallery_worship_place';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'worship_place_id', 'url'];

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
        $count = (int)substr($lastId['id'], 3);
        $id = sprintf('IMG%04d', $count + 1);
        return $id;
    }

    public function get_gallery_api($worship_place_id = null) {
        $query = $this->db->table($this->table)
            ->select('url')
            ->where('worship_place_id', $worship_place_id)
            ->get();
        return $query;
    }

    public function add_gallery_api($id = null, $data = null) {
        $query = false;
        foreach ($data as $gallery) {
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'worship_place_id' => $id,
                'url' => $gallery,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_gallery_api($id = null, $data = null) {
        $queryDel = $this->db->table($this->table)->delete(['worship_place_id' => $id]);
        $queryIns = $this->add_gallery_api($id, $data);
        return $queryDel && $queryIns;
    }
}
