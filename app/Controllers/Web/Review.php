<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\ReviewModel;
use CodeIgniter\I18n\Time;

class Review extends BaseController
{
    protected $reviewModel;
    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }
    
    public function add()
    {
        $request = $this->request->getPost();
        $requestData = [
            'id' => $this->reviewModel->get_new_id_api(),
            'comment' => $request['comment'],
            'date' => Time::now(),
            'rating' => $request['rating'],
            'user_id' => user()->id,
        ];
        if (isset($request['rumah_gadang_id'])) {
            $requestData['rumah_gadang_id'] = $request['rumah_gadang_id'];
            $addReview = $this->reviewModel->add_review_api($requestData);
            if ($addReview) {
                return redirect()->to(base_url('web/rumahGadang') . '/' . $request['rumah_gadang_id'] . '#reviews');
            }
        }
        
        $requestData['event_id'] = $request['event_id'];
        $addReview = $this->reviewModel->add_review_api($requestData);
        if ($addReview) {
            return redirect()->to(base_url('web/event') . '/' . $request['event_id'] . '#reviews');
        }
        return redirect()->to(base_url('web'));
    }
}
