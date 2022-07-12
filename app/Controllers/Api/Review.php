<?php

namespace App\Controllers\Api;

use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class Review extends ResourceController
{
    use ResponseTrait;

    protected $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
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
     * @throws \ReflectionException
     * @throws \Exception
     */
    public function create()
    {
        $request = $this->request->getPost();
        $requestData = [
            'id' => $this->reviewModel->get_new_id_api(),
            'rumah_gadang_id' => $request['rumah_gadang_id'],
            'event_id' => $request['event_id'],
            'comment' => $request['comment'],
            'date' => Time::now(),
            'rating' => $request['rating'],
            'user_id' => $request['user_id'],
        ];
        $addReview = $this->reviewModel->add_review_api($requestData);
        if($addReview) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new review"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new review"
                ]
            ];
            return $this->fail($response);
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
