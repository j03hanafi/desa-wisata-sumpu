<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Models\VisitHistoryModel;

class Profile extends BaseController
{
    protected $accountModel;
    protected $visitHistoryModel;
    
    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->visitHistoryModel = new VisitHistoryModel();
    }
    
    public function profile()
    {
        $data = [
            'title' => 'My Profile'
        ];
        return view('web/profile/manage_profile', $data);
    }
    public function updateProfile()
    {
        $data = [
            'title' => 'My Profile'
        ];
        return view('web/profile/update_profile', $data);
    }
    
    public function changePassword()
    {
        $data = [
            'title' => 'Change Password'
        ];
        return view('web/profile/change_password', $data);
    }
    
    public function update() {
        $request = $this->request->getPost();
        $requestData = [
            'username' => $request['username'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'avatar' => $request['avatar'],
        ];
        $this->accountModel->insert($requestData);
        $data = [
            'title' => 'Change Password'
        ];
        return view('web/profile/change_password', $data);
    }
}
