<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class EventModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'event';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $allowedFields    = ['id', 'name', 'date_start','date_end', 'description', 'ticket_price', 'contact_person', 'category_id', 'owner', 'lat', 'long'];

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
    public function get_list_ev_api() {
        $query = $this->db->table($this->table)
            ->select('event.*, category_event.category, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('category_event', 'event.category_id = category_event.id')
            ->join('account', 'event.owner = account.id')
            ->get();
        return $query;
    }

    public function list_by_owner_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('event.*, category_event.category, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('owner', $id)
            ->join('category_event', 'event.category_id = category_event.id')
            ->join('account', 'event.owner = account.id')
            ->get();
        return $query;
    }

    public function get_ev_by_id_api($id = null) {
        $query = $this->db->table($this->table)
            ->select('event.*, category_event.category, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->where('event.id', $id)
            ->join('category_event', 'event.category_id = category_event.id')
            ->join('account', 'event.owner = account.id')
            ->get();
        return $query;
    }

    public function get_ev_by_name_api($name = null) {
        $query = $this->db->table($this->table)
            ->select('event.*, category_event.category, CONCAT(account.first_name, " ", account.last_name) as owner_name')
            ->join('category_event', 'event.category_id = category_event.id')
            ->join('account', 'event.owner = account.id')
            ->like('name', $name)
            ->get();
        return $query;
    }

    public function get_new_id_api() {
        $count = $this->db->table($this->table)->countAll();
        $id = sprintf('EV%03d', $count + 1);
        return $id;
    }

    public function add_ev_api($event = null) {
        foreach ($event as $key => $value) {
            if(empty($value)) {
                unset($event[$key]);
            }
        }
        $event['created_at'] = Time::now();
        $event['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->insert($event);
        return $query;
    }

    public function update_ev_api($id = null, $event = null) {
        foreach ($event as $key => $value) {
            if(empty($value)) {
                unset($event[$key]);
            }
        }
        $event['updated_at'] = Time::now();
        $query = $this->db->table($this->table)
            ->where('id', $id)
            ->update($event);
        return $query;
    }
}
