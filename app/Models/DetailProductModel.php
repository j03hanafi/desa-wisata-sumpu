<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class DetailProductModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_product';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'souvenir_place_id', 'product_id', 'price'];

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
    public function get_product_by_id_api($souvenir_place_id = null) {
        $query = $this->db->table($this->table)
            ->select('product.id, product.name, product.photo, detail_product.price')
            ->where('souvenir_place_id', $souvenir_place_id)
            ->join('product', 'detail_product.product_id = product.id')
            ->get();
        return $query;
    }

    public function get_product_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('product.id, product.name, product.photo, detail_product.souvenir_place_id, detail_product.price')
            ->join('product', 'detail_product.product_id = product.id')
            ->like('product.name', $name)
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('DPR%03d', $count + 1);
        return $id;
    }

    public function add_product_api($id = null, $data = null) {
        $query = false;
        foreach ($data as $product) {
            $productArr = (array)$product;
            $new_id = $this->get_new_id_api();
            $content = [
                'id' => $new_id,
                'souvenir_place_id' => $id,
                'product_id' => $productArr['id'],
                'price' => $productArr['price'],
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $query = $this->db->table($this->table)->insert($content);
        }
        return $query;
    }

    public function update_product_api($id = null, $data = null) {
        $queryDel = $this->db->table($this->table)->delete(['souvenir_place_id' => $id]);
        $queryIns = $this->add_product_api($id, $data);
        return $queryDel && $queryIns;
    }
}
