<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class VideoEventModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'video_event';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'event_id', 'url','duration', 'view'];

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
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('VID%04d', $count + 1);
        return $id;
    }

    public function get_video_api($event_id = null) {
        $query = $this->db->table($this->table)
            ->select('url')
            ->where('event_id', $event_id)
            ->get();
        return $query;
    }

    public function add_video_api($id = null, $data = null) {
        $query = false;
        foreach ($data as $video) {
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'event_id' => $id,
                'url' => $video['url'],
                'duration' => $video['duration'],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_video_api($id = null, $data = null) {
        $queryDel = $this->db->table($this->table)->delete(['event_id' => $id]);
        $queryIns = $this->add_video_api($id, $data);
        return $queryDel && $queryIns;
    }
}
