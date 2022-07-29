<?php

namespace App\Controllers\Web;

use App\Models\AccountModel;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Password;

class Users extends ResourcePresenter
{
    protected $accountModel;
    protected $helpers = ['auth', 'url', 'filesystem'];
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
    
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');
    
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }
    
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $contents = $this->accountModel->get_account_by_id_api($id)->getRowArray();
        $data = [
            'title' => $contents['first_name'] . ' ' . $contents['last_name'],
            'data' => $contents,
        ];
        return view('dashboard/detail_user', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        return redirect()->to(previous_url());
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
    
    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $contents = $this->accountModel->get_account_by_id_api($id)->getRowArray();
        $roles = $this->accountModel->get_roles_api()->getResultArray();
        $data = [
            'title' => 'Update User',
            'data' => $contents,
            'roles' => $roles
        ];
        return view('dashboard/user_form', $data);
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = [
            'title' => 'Update User',
            'errors' => []
        ];
        
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
        
        if (!empty($request['password'])){
            $rules = [
                'password'     => 'strong_password',
                'pass_confirm' => 'matches[password]',
            ];
    
            if (! $this->validate($rules))
            {
                return redirect()->back()->withInput();
            }
    
            $passwordData = [
                'password_hash' => Password::hash($request['password']),
                'reset_hash' => null,
                'reset_at' => null,
                'reset_expires' => null,
            ];
            $updatePassword = $this->accountModel->change_password_user($id, $passwordData);
        }
    
        if (($request['avatar']) != 'default.jpg') {
            $folder = $request['avatar'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $avatar = new File($filepath . '/' . $filenames[0]);
            $avatar->move(FCPATH . 'media/photos');
            $requestData['avatar'] = $avatar->getFilename();
            delete_files($filepath);
            rmdir($filepath);
        } else {
            $requestData['avatar'] = 'default.jpg';
        }
        $role = [
            'group_id' => $request['role']
        ];
    
        $updateUser = $this->accountModel->update_account_users($id, $requestData);
        $updateRole = $this->accountModel->update_role_api($id, $role);
        if ($updateUser && $updateRole) {
            return redirect()->to(base_url('dashboard/users') . '/' . $id);
        } else {
            redirect()->back()->withInput();
        }
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        //
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
