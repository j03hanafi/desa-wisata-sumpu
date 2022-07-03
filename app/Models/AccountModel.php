<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'account';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'username', 'first_name', 'last_name', 'email', 'address', 'phone', 'password', 'avatar', 'last_login', 'role_id'];

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
        $id = sprintf('ACC%04d', $count + 1);
        return $id;
    }

    public function change_password_api($id = null, $data = null) {
        $count = $this->db->table($this->table)->select('*')->where('id', $id)->where('password', $data['current_password'])->countAllResults();
        $data = [
            'password' => $data['new_password'],
        ];
        $query = false;
        if ($count > 0) {
            $query = $this->db->table($this->table)
                ->update($data, ['id' => $id]);
        }
        return $query;
    }

    public function update_account_api($id = null, $data = null) {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                unset($data[$key]);
            }
        }
        $query = $this->db->table($this->table)
            ->update($data, ['id' => $id]);
        return $query;
    }

    public function get_list_owner_api() {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('role_id', 'OWNR')
            ->get();
        return $query;
    }

    public function get_list_user_api() {
        $query = $this->db->table($this->table)
            ->select('*')
            ->get();
        return $query;
    }

    public function get_account_by_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('*')
            ->where('id', $id)
            ->get();
        return $query;
    }
}
