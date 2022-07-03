<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class RumahGadangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'rumah_gadang';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'address', 'open', 'close', 'ticket_price', 'geom', 'contact_person', 'status', 'recom', 'owner', 'description', 'video_url'];

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
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("rumah_gadang.id, rumah_gadang.name, {$coords}")
            ->from('village')
            ->where('recom', 'REC01')
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function recommendation_by_owner_api($id = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}, recommendation.name as recommendation")
            ->from('village')
            ->where($vilGeom)
            ->where('recom', 'REC01')
            ->where('owner', $id)
            ->join('recommendation', 'rumah_gadang.recom = recommendation.id')
            ->get();
        return $query;
    }

    public function get_list_rg_api() {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function list_by_owner_api($id = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->where($vilGeom)
            ->where('owner', $id)
            ->get();
        return $query;
    }

    public function get_rg_by_id_api($id = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->where('rumah_gadang.id', $id)
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function get_rg_by_name_api($name = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->like("{$this->table}.name", $name)
            ->where($vilGeom)
            ->get();
        return $query;
    }
    
    public function get_rg_by_status_api($status = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->where("{$this->table}.status", $status)
            ->where($vilGeom)
            ->get();
        return $query;
    }
    
    public function get_rg_by_radius_api($data = null) {
        $radius = (int)$data['radius'] / 1000;
        $lat = $data['lat'];
        $long = $data['long'];
        $jarak = "(6371 * acos(cos(radians({$lat})) * cos(radians(ST_Y(ST_CENTROID({$this->table}.geom)))) * cos(radians(ST_X(ST_CENTROID({$this->table}.geom))) - radians({$long})) + sin(radians({$lat}))* sin(radians(ST_Y(ST_CENTROID({$this->table}.geom))))))";
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}, {$jarak} as jarak")
            ->from('village')
            ->where($vilGeom)
            ->having(['jarak <=' => $radius])
            ->get();
        return $query;
    }
    
    public function get_rg_in_id_api($id = null) {
        $coords = "ST_Y(ST_Centroid({$this->table}.geom)) AS lat, ST_X(ST_Centroid({$this->table}.geom)) AS lng";
        $columns = "{$this->table}.id,{$this->table}.name,{$this->table}.address,{$this->table}.open,{$this->table}.close,{$this->table}.ticket_price,{$this->table}.contact_person,{$this->table}.status,{$this->table}.recom,{$this->table}.owner,{$this->table}.description,{$this->table}.video_url";
        $vilGeom = "village.id = 'VIL01' AND ST_Contains(village.geom, {$this->table}.geom)";
        $query = $this->db->table($this->table)
            ->select("{$columns}, {$coords}")
            ->from('village')
            ->whereIn('rumah_gadang.id', $id)
            ->where($vilGeom)
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('RG%03d', $count + 1);
        return $id;
    }

    public function add_rg_api($rumah_gadang = null, $geojson = null) {
        foreach ($rumah_gadang as $key => $value) {
            if(empty($value)) {
                unset($rumah_gadang[$key]);
            }
        }
        $rumah_gadang['created_at'] = Time::now();
        $rumah_gadang['updated_at'] = Time::now();
        $insert = $this->db->table($this->table)
            ->insert($rumah_gadang);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $rumah_gadang['id'])
            ->update();
        return $insert && $update;
    }

    public function update_rg_api($id = null, $rumah_gadang = null, $geojson = null) {
        foreach ($rumah_gadang as $key => $value) {
            if(empty($value)) {
                unset($rumah_gadang[$key]);
            }
        }
        $rumah_gadang['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($rumah_gadang);
        $update = $this->db->table($this->table)
            ->set('geom', "ST_GeomFromGeoJSON('{$geojson}')", false)
            ->where('id', $id)
            ->update();
        return $query && $update;
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
