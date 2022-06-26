<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LandingPage extends BaseController
{
    public function index()
    {
        
        return view('landing_page');
    }
}
