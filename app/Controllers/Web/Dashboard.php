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
        $data = [
            'title' => 'Dashboard',
        ];
        return view('dashboard/analytics', $data);
    }
    
    public function rumahGadang()
    {
        $contents = $this->rumahGadangModel->get_list_rg_api()->getResultArray();
        $data = [
            'title' => 'Manage Rumah Gadang',
            'category' => 'Rumah Gadang',
            'data' => $contents,
        ];
        return view('dashboard/manage', $data);
    }
    
    public function event()
    {
        $contents = $this->eventModel->get_list_ev_api()->getResultArray();
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
        $contents = $this->rumahGadangModel->get_list_recommendation_api()->getResultArray();
        $data = [
            'title' => 'Manage Recommendation',
            'category' => 'Recommendation',
            'data' => $contents,
        ];
        return view('dashboard/recommendation', $data);
    }
}
