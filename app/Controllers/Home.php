<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;

class Home extends BaseController
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
    
    public function __construct()
    {
        // Most services in this controller require
        // the session to be started - so fire it up!
        $this->session = service('session');
        
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }
    
    public function index()
    {
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
    
    public function error403()
    {
        return view('errors/html/error_403');
    }
    
    public function dbCheck()
    {
        $db = db_connect();
        $content = [
            'Platform' => $db->getPlatform(),
            'Version' => $db->getVersion(),
            'Database' => $db->getDatabase(),
        ];
        $response = [
            'data' => $content,
            'status' => 200,
            'message' => [
                "Successfully Connected to Database"
            ]
        ];
        return $this->respond($response);
    }
}
