<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('web/auth/login', $data);
    }
    
    public function register()
    {
        $data = [
            'title' => 'Register',
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
}
