<?php

namespace App\Controllers\Web;

use App\Models\EventModel;
use App\Models\GalleryEventModel;
use App\Models\ReviewModel;
use App\Models\VideoEventModel;
use CodeIgniter\RESTful\ResourceController;

class Event extends ResourceController
{
    protected $eventModel;
    protected $galleryEventModel;
    protected $videoEventModel;
    protected $reviewModel;
    
    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->galleryEventModel = new GalleryEventModel();
        $this->videoEventModel = new VideoEventModel();
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
        return view('web/visitor/list_event', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();
        $avg_rating = $this->reviewModel->get_rating('event_id', $id)->getRowArray()['avg_rating'];
    
        $list_gallery = $this->galleryEventModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
    
        $list_video = $this->videoEventModel->get_video_api($id)->getResultArray();
        $videos = array();
        foreach ($list_video as $video) {
            $videos[] = $video['url'];
        }
    
        $list_review = $this->reviewModel->get_review_object_api('event_id', $id)->getResultArray();
    
        $event['avg_rating'] = $avg_rating;
        $event['gallery'] = $galleries;
        $event['video'] = $videos;
        $event['reviews'] = $list_review;
    
        $data = [
            'title' => 'Event',
            'data' => $event,
        ];
    
        return view('web/visitor/detail_event', $data);
    
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
    
    public function findByName()
    {
        $data = [
            'title' => 'Event',
        ];
        if ($this->request->getMethod() == 'post') {
            $request = $this->request->getPost();
            $name = $request['name'];
            $contents = $this->eventModel->get_ev_by_name_api($name)->getResultArray();
            $data['data'] = $contents;
            $data['input'] = $name;
        }
        return view('web/visitor/list_event', $data);
    }
    
    public function findByRadius()
    {
        $data = [
            'title' => 'Event',
        ];
        if ($this->request->getMethod() == 'post') {
            $request = $this->request->getPost();
            $contents = $this->eventModel->get_ev_by_radius_api($request)->getResultArray();
            $data['data'] = $contents;
            $data['radius'] = [$request['lat'], $request['long'], $request['radius']];
        }
    
        return view('web/visitor/list_event', $data);
    }
}
