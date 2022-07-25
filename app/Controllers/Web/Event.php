<?php

namespace App\Controllers\Web;

use App\Models\EventModel;
use App\Models\GalleryEventModel;
use App\Models\ReviewModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Event extends ResourcePresenter
{
    protected $eventModel;
    protected $galleryEventModel;
    protected $reviewModel;
    protected $helpers = 'auth';
    
    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->galleryEventModel = new GalleryEventModel();
        $this->reviewModel = new ReviewModel();
    }
    
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->eventModel->get_list_ev_api()->getResultArray();
        $data = [
            'title' => 'Event',
            'data' => $contents,
        ];
        return view('web/list_event', $data);
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
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();
        if (empty($event)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }
    
        $avg_rating = $this->reviewModel->get_rating('event_id', $id)->getRowArray()['avg_rating'];
    
        $list_gallery = $this->galleryEventModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
    
        $list_review = $this->reviewModel->get_review_object_api('event_id', $id)->getResultArray();
    
        $event['avg_rating'] = $avg_rating;
        $event['gallery'] = $galleries;
        $event['reviews'] = $list_review;
    
        $data = [
            'title' => 'Event',
            'data' => $event,
        ];
    
        if (url_is('*dashboard*')) {
            return view('dashboard/detail_event', $data);
        }
        return view('web/detail_event', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        //
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
        //
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
        //
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
