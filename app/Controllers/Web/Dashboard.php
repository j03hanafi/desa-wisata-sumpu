<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Models\EventModel;
use App\Models\FacilityRumahGadangModel;
use App\Models\RumahGadangModel;

class Dashboard extends BaseController
{
    protected $rumahGadangModel;
    protected $eventModel;
    protected $facilityModel;
    protected $accountModel;
    protected $helpers = ['auth'];
    
    public function __construct()
    {
        $this->rumahGadangModel = new RumahGadangModel();
        $this->eventModel = new EventModel();
        $this->facilityModel = new FacilityRumahGadangModel();
        $this->accountModel = new AccountModel();
    }
    public function index()
    {
        return redirect()->to(base_url('/dashboard/rumahGadang'));
    }
    
    public function rumahGadang()
    {
        $contents = [];
        if (in_groups('admin')) {
            $contents = $this->rumahGadangModel->get_list_rg_api()->getResultArray();
        } elseif (in_groups('owner')) {
            $contents = $this->rumahGadangModel->list_by_owner_api(user()->id)->getResultArray();
        }
        
        $data = [
            'title' => 'Manage Rumah Gadang',
            'category' => 'Rumah Gadang',
            'data' => $contents,
        ];
        return view('dashboard/manage', $data);
    }
    
    public function event()
    {
        $contents = [];
        if (in_groups('admin')) {
            $contents = $this->eventModel->get_list_ev_api()->getResultArray();
        } elseif (in_groups('owner')) {
            $contents = $this->eventModel->list_by_owner_api(user()->id)->getResultArray();
        }
        
        $data = [
            'title' => 'Manage Event',
            'category' => 'Event',
            'data' => $contents,
        ];
        return view('dashboard/manage', $data);
    }
    
    public function facility()
    {
        $contents = $this->facilityModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'Manage Facility',
            'category' => 'Facility',
            'data' => $contents,
        ];
        return view('dashboard/manage', $data);
    }
    
    public function users()
    {
        $contents = $this->accountModel->get_list_user_api()->getResultArray();
        $data = [
            'title' => 'Manage Users',
            'category' => 'Users',
            'data' => $contents,
        ];
        return view('dashboard/manage', $data);
    }
    
    public function recommendation()
    {
        $contents = [];
        if (in_groups('admin')) {
            $contents = $this->rumahGadangModel->get_list_recommendation_api()->getResultArray();
        } elseif (in_groups('owner')) {
            $contents = $this->rumahGadangModel->recommendation_by_owner_api(user()->id)->getResultArray();
        }
        
        $recommendations = $this->rumahGadangModel->get_recommendation_data_api()->getResultArray();
        $data = [
            'title' => 'Manage Recommendation',
            'category' => 'Recommendation',
            'data' => $contents,
            'recommendations' => $recommendations,
        ];
        return view('dashboard/recommendation', $data);
    }
}
