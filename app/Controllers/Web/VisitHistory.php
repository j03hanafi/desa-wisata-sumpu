<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\AccountModel;
use App\Models\VisitHistoryModel;
use CodeIgniter\Session\Session;
use Myth\Auth\Config\Auth as AuthConfig;

class VisitHistory extends BaseController
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
        return view('web/visit_history', $data);
    }
    
    public function addVisitHistory()
    {
        $data = [
            'title' => 'Visit History',
        ];
        return view('web/add_visit_history', $data);
    }
}
