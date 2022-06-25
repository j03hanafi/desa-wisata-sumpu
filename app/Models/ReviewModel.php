<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'review';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'rumah_gadang_id', 'event_id', 'culinary_place_id', 'worship_place_id', 'souvenir_place_id', 'comment', 'date', 'rating', 'account_id', 'status'];

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
        $id = sprintf('RV%04d', $count + 1);
        return $id;
    }

    public function add_review_api($review = null) {
        foreach ($review as $key => $value) {
            if(empty($value)) {
                unset($review[$key]);
            }
        }
        $status = 0;
        foreach ($review as $key => $value) {
            if ($key == 'rumah_gadang_id') {
                $status = 1;
            } elseif ($key == 'event_id') {
                $status = 2;
            } elseif ($key == 'culinary_place_id') {
                $status = 3;
            } elseif ($key == 'worship_place_id') {
                $status = 4;
            } elseif ($key == 'souvenir_place_ids') {
                $status = 5;
            }
        }
        $review['status'] = $status;
        $review['created_at'] = Time::now();
        $review['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($review);
        return $query;
    }

    public function get_review_object_api($object = null, $id = null) {
        $query = $this->db->table($this->table)
            ->select('review.*, account.first_name, account.last_name')
            ->where($object, $id)
            ->join('account', 'review.account_id = account.id')
            ->get();
        return $query;
    }
}
