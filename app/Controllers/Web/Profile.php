<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Models\VisitHistoryModel;
use CodeIgniter\Session\Session;
use CodeIgniter\Files\File;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Profile extends BaseController
{
    protected $accountModel;
    protected $visitHistoryModel;
    protected $auth;
    
    /**
     * @var AuthConfig
     */
    protected $config;
    
    /**
     * @var Session
     */
    protected $session;
    
    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->visitHistoryModel = new VisitHistoryModel();
    
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');
    
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }
    
    public function login() {
        $data = [
            'title' => 'Login',
            'config' => $this->config,
        ];
        return view('web/auth/login', $data);
    }
    
    public function register()
    {
        $data = [
            'title' => 'Register',
            'config' => $this->config,
        ];
        return view('web/auth/register', $data);
    }
    
    public function profile()
    {
        $data = [
            'title' => 'My Profile',
            'datas' => [],
        ];
        return view('web/profile/manage_profile', $data);
    }
    public function updateProfile()
    {
        $data = [
            'title' => 'My Profile',
            'errors' => [],
        ];
        return view('web/profile/update_profile', $data);
    }
    
    public function changePassword()
    {
        $data = [
            'title' => 'Change Password',
            'errors' => [],
            'success' => false
        ];
    
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'password'     => 'required|strong_password',
                'pass_confirm' => 'required|matches[password]',
            ];
    
            if (! $this->validate($rules))
            {
                $data['errors'] = $this->validator->getErrors();
                return view('web/profile/change_password', $data);
            }
    
            $requestData = [
                'password_hash' => Password::hash($this->request->getPost()['password']),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $query = $this->accountModel->change_password_user(user()->id, $requestData);
            if ($query) {
                $data['errors'] = ['Password is changed'];
                $data['success'] = true;
                return view('web/profile/change_password', $data);
            }
            $data['errors'] = ['Failed change password'];
            return view('web/profile/change_password', $data);
            
        }
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
        ];
        foreach ($requestData as $key => $value) {
            if(empty($value)) {
                unset($requestData[$key]);
            }
        }
        $img = $this->request->getFile('avatar');
        
        if ($img == null) {
            $query = $this->accountModel->update_account_users(user()->id, $requestData);
            if ($query) {
                return redirect()->to('web/profile');
            }
            $data = [
                'title' => 'Update Profile',
                'errors' => ['Error update']
            ];
    
            return view('web/profile/update_profile', $data);
        } else {
            $validationRule = [
                'avatar' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[avatar]'
                        . '|is_image[avatar]'
                        . '|mime_in[avatar,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ],
            ];
            if (!$this->validate($validationRule)) {
                $data = [
                    'title' => 'Update Profile',
                    'errors' => $this->validator->getErrors()
                ];
        
                return view('web/profile/update_profile', $data);
            }
    
            if (!$img->hasMoved()) {
                $filepath = WRITEPATH . 'uploads/' . $img->store();
                $avatar = new File($filepath);
                $avatar->move(FCPATH . 'media/photos');
                $requestData['avatar'] = $avatar->getFilename();
    
                $query = $this->accountModel->update_account_users(user()->id, $requestData);
                if ($query) {
                    
                    return redirect()->to('web/profile');
                }
                $data = [
                    'title' => 'Update Profile',
                    'errors' => ['Error update. ' . $query]
                ];
        
                return view('web/profile/update_profile', $data);
        
            }
        }
        
        $data = [
            'title' => 'Update Profile',
            'errors' => ['The file has already been moved.']
        ];
    
        return view('web/profile/update_profile', $data);
    }
    
    public function visitHistory()
    {
        $data = [
            'title' => 'Visit History',
        ];
        if ($this->request->getMethod() == 'post') {
            $request = $this->request->getPost();
            $request = $this->request->getPost();
            $requestData = [
                'id' => $this->visitHistoryModel->get_new_id_api(),
                'user_id' => user()->id,
                'object_id' => $request['object_id'],
                'category' => $request['category'],
                'date_visit' => $request['date_visit'],
            ];
            $this->visitHistoryModel->insert($requestData);
            return redirect()->to(base_url('web/visitHistory'));
        }
        $list_visit = $this->visitHistoryModel->get_visit_history_by_id_api(user()->id)->getResultArray();
        $list_object = $this->visitHistoryModel->get_visited_object_api($list_visit);
        $data['data'] = $list_object;
        return view('web/visitor/visit_history', $data);
    }
    
    public function addVisitHistory()
    {
        $data = [
            'title' => 'Visit History',
        ];
        return view('web/visitor/add_visit_history', $data);
    }
}
