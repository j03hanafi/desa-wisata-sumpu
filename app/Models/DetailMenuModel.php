<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class DetailMenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_menu';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'culinary_place_id', 'menu_id', 'price'];

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
    public function get_menu_by_id_api($culinary_place_id = null) {
        $query = $this->db->table($this->table)
            ->select('menu.id, menu.name, menu.photo, detail_menu.price')
            ->where('culinary_place_id', $culinary_place_id)
            ->join('menu', 'detail_menu.menu_id = menu.id')
            ->get();
        return $query;
    }

    public function get_menu_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('menu.id, menu.name, menu.photo, detail_menu.culinary_place_id, detail_menu.price')
            ->join('menu', 'detail_menu.menu_id = menu.id')
            ->like('menu.name', $name)
            ->get();
        return $query;
    }

    public function get_menu_by_price_api($min = null, $max = null) {
        if(!is_null($max)) {
            $min = is_null($min) ? "0" : $min;
            $price_limit = "price >= {$min} AND price <= {$max}";
        } else {
            $min = is_null($min) ? "0" : $min;
            $price_limit = "price >= {$min}";
        }
        $query = $this->db->table($this->table)
            ->select('menu.id, menu.name, menu.photo, detail_menu.culinary_place_id, detail_menu.price')
            ->join('menu', 'detail_menu.menu_id = menu.id')
            ->where($price_limit)
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('DMN%03d', $count + 1);
        return $id;
    }

    public function add_menu_api($id = null, $data = null) {
        $query = false;
        foreach ($data as $menu) {
            $menuArr = (array)$menu;
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'culinary_place_id' => $id,
                'menu_id' => $menuArr['id'],
                'price' => $menuArr['price'],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_menu_api($id = null, $data = null) {
        $queryDel = $this->db->table($this->table)->delete(['culinary_place_id' => $id]);
        $queryIns = $this->add_menu_api($id, $data);
        return $queryDel && $queryIns;
    }
}
