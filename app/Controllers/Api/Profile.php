<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;

class Profile extends ResourceController
{
    use ResponseTrait;
    protected $auth;
    
    /**
     * @var AuthConfig
     */
    protected $config;
    
    /**
     * @var Session
     */
    protected $session;
    
    protected $helpers = ['auth', 'filesystem'];
    
    public function __construct()
    {
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');
        
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }
    
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
    
    /**
     * Attempts to verify the user's credentials
     * through a POST request.
     */
    public function attemptLogin()
    {
        
        $rules = [
            'login'	=> 'required',
            'password' => 'required',
        ];
        if ($this->config->validFields == ['email'])
        {
            $rules['login'] .= '|valid_email';
        }
        
        if (! $this->validate($rules))
        {
            $contents = $this->validator->getErrors();
            $response = [
                'data' => $contents,
                'status' => 400,
                'message' => [
                    "Error validate credentials"
                ]
            ];
            return $this->respond($response, 400);
        }
        
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        
        // Determine credential type
        $type = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        // Try to log them in...
        if (! $this->auth->attempt([$type => $login, 'password' => $password], false))
        {
            $contents = $this->auth->error();
            $response = [
                'data' => $contents,
                'status' => 400,
                'message' => [
                    "Error login"
                ]
            ];
            return $this->respond($response, 400);
        }
        
        $redirectURL = session('redirect_url') ?? site_url('/web');
        unset($_SESSION['redirect_url']);
    
        $contents = [
            'url' => $redirectURL,
            'user' => user(),
            'in_group' => in_groups('user')
        ];
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success login"
            ]
        ];
        return $this->respond($response, 200);
    }
    
    public function profile()
    {
        $id = $this->request->getPost('id');
        if (logged_in()){
            if (user()->id == $id)
            {
                $contents = user();
                $response = [
                    'data' => $contents,
                    'status' => 200,
                    'message' => [
                        "Getting user data"
                    ]
                ];
                return $this->respond($response, 200);
            }
        }
        
        $response = [
            'status' => 400,
            'message' => [
                "Failed get user data"
            ]
        ];
        return $this->respond($response, 400);
    }
    
    public function logout()
    {
        if ($this->auth->check())
        {
            $this->auth->logout();
        }
    
        $response = [
            'status' => 200,
            'message' => [
                "Successfully logged out"
            ]
        ];
        return $this->respond($response, 200);
    }
}

