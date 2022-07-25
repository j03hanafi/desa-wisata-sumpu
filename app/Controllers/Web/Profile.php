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
        return view('auth/login', $data);
    }
    
    public function register()
    {
        $data = [
            'title' => 'Register',
            'config' => $this->config,
        ];
        return view('auth/register', $data);
    }
    
    public function profile()
    {
        $data = [
            'title' => 'My Profile',
            'datas' => [],
        ];
        return view('profile/manage_profile', $data);
    }
    public function updateProfile()
    {
        $data = [
            'title' => 'My Profile',
            'errors' => [],
        ];
        return view('profile/update_profile', $data);
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
                return view('profile/change_password', $data);
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
                return view('profile/change_password', $data);
            }
            $data['errors'] = ['Failed change password'];
            return view('profile/change_password', $data);
            
        }
        return view('profile/change_password', $data);
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
        
        if (isset($request['avatar'])) {
            $folder = $request['avatar'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $avatar = new File($filepath . '/' . $filenames[0]);
            $avatar->move(FCPATH . 'media/photos');
            $requestData['avatar'] = $avatar->getFilename();
    
            $query = $this->accountModel->update_account_users(user()->id, $requestData);
            if ($query) {
                delete_files($filepath);
                rmdir($filepath);
                return redirect()->to('web/profile');
            }
            $data = [
                'title' => 'Update Profile',
                'errors' => ['Error update. ' . $query]
            ];
            
        } else {
            $requestData['avatar'] = 'default.jpg';
            $query = $this->accountModel->update_account_users(user()->id, $requestData);
            if ($query) {
                return redirect()->to('web/profile');
            }
            $data = [
                'title' => 'Update Profile',
                'errors' => ['Error update']
            ];
        }
        return view('profile/update_profile', $data);
    }
}
