<?php

namespace App\Controllers\Web;

use App\Models\EventModel;
use App\Models\GalleryEventModel;
use App\Models\ReviewModel;
use CodeIgniter\RESTful\ResourceController;

class Event extends ResourceController
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
     * Return an array of resource objects, themselves in array format
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
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();
        if (empty($event)) {
            return redirect()->to(base_url('web/event'));
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
    
        return view('web/detail_event', $data);
    
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
}
