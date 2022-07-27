<?php

namespace App\Controllers\Api;

use App\Models\CategoryEventModel;
use App\Models\EventModel;
use App\Models\GalleryEventModel;
use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Event extends ResourceController
{
    use ResponseTrait;

    protected $eventModel;
    protected $galleryEventModel;
    protected $reviewModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->galleryEventModel = new GalleryEventModel();
        $this->reviewModel = new ReviewModel();
        $this->categoryModel = new CategoryEventModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->eventModel->get_list_ev_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Event"
            ]
        ];
        return $this->respond($response);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();

        $list_gallery = $this->galleryEventModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $list_review = $this->reviewModel->get_review_object_api('event_id', $id)->getResultArray();

        $event['gallery'] = $galleries;
        $event['reviews'] = $list_review;

        $response = [
            'data' => $event,
            'status' => 200,
            'message' => [
                "Success display detail information of Event"
            ]
        ];
        return $this->respond($response);
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
        $request = $this->request->getJSON(true);
        $id = $this->eventModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
            'description' => $request['description'],
            'ticket_price' => $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'category_id' => $request['category_id'],
            'owner' => $request['owner'],
            'video_url' => $request['video_url'],
        ];
        foreach ($requestData as $key => $value) {
            if(empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geojson'];
        $addEV = $this->eventModel->add_ev_api($requestData, $geojson);
        $gallery = $request['gallery'];
        $addGallery = $this->galleryEventModel->add_gallery_api($id, $gallery);
        if($addEV && $addGallery) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new event"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new event",
                    "Add Event: {$addEV}",
                    "Add Gallery: {$addGallery}",
                ]
            ];
            return $this->respond($response, 400);
        }
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
        $request = $this->request->getJSON(true);
        $requestData = [
            'name' => $request['name'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
            'description' => $request['description'],
            'ticket_price' => $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'category_id' => $request['category_id'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
        ];
        $updateEV = $this->eventModel->update_ev_api($id, $requestData);
        $gallery = $request['gallery'];
        $updateGallery = $this->galleryEventModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoEventModel->update_video_api($id, array($video));
        if($updateEV && $updateGallery && $updateVideo) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success update event"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update event",
                    "Update Event: {$updateEV}",
                    "Update Gallery: {$updateGallery}",
                    "Update Video: {$updateVideo}",
                ]
            ];
            return $this->respond($response, 400);
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $deleteEV = $this->eventModel->delete(['id' => $id]);
        if($deleteEV) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete event"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Event not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function findByName()
    {
        $request = $this->request->getPost();
        $name = $request['name'];
        $contents = $this->eventModel->get_ev_by_name_api($name)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find event by name"
            ]
        ];
        return $this->respond($response);
    }
    
    public function findByRadius()
    {
        $request = $this->request->getPost();
        $contents = $this->eventModel->get_ev_by_radius_api($request)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find event by radius"
            ]
        ];
        return $this->respond($response);
    }
    
    public function findByRating()
    {
        $request = $this->request->getPost();
        $rating = $request['rating'];
        $list_rating = $this->reviewModel->get_object_by_rating_api('event_id', $rating)->getResultArray();
        $event_id = array();
        foreach ($list_rating as $rat) {
            $event_id[] = $rat['event_id'];
        }
        if (count($event_id) > 0) {
            $contents = $this->eventModel->get_ev_in_id_api($event_id)->getResult();
        } else {
            $contents = [];
        }
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find event by rating"
            ]
        ];
        return $this->respond($response);
    }
    
    public function findByCategory()
    {
        $request = $this->request->getPost();
        $category = $request['category'];
        $contents = $this->eventModel->get_ev_by_category_api($category)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find event by category"
            ]
        ];
        return $this->respond($response);
    }
    
    public function findByDate()
    {
        
        $request = $this->request->getPost();
        $date = $request['date']; // YYYY-MM-DD
        $contents = $this->eventModel->get_ev_by_date_api($date)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find event by date"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->eventModel->list_by_owner_api($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Event"
            ]
        ];
        return $this->respond($response);
    }
    
    public function category() {
        $contents = $this->categoryModel->get_list_cat_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of category"
            ]
        ];
        return $this->respond($response);
    }
}
