<?php

namespace App\Controllers;

use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;

class Home extends BaseController
{
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
    
    public function visitHistory()
    {
        $data = [
            'title' => 'Visit History',
        ];
        return view('web/visitor/visit_history', $data);
    }
    
    public function addVisitHistory()
    {
        $data = [
            'title' => 'Visit History',
        ];
        return view('web/visitor/add_visit_history', $data);
    }
    
    public function error403()
    {
        return view('errors/html/error-403');
    }
}
