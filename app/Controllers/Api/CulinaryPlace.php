<?php

namespace App\Controllers\Api;

use App\Models\CulinaryPlaceModel;
use App\Models\GalleryCulinaryPlaceModel;
use App\Models\ReviewModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class CulinaryPlace extends ResourceController
{
    use ResponseTrait;

    protected $culinaryPlaceModel;
    protected $galleryCulinaryPlaceModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->culinaryPlaceModel = new CulinaryPlaceModel();
        $this->galleryCulinaryPlaceModel = new GalleryCulinaryPlaceModel();
        $this->reviewModel = new ReviewModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->culinaryPlaceModel->get_list_cp_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Culinary Place"
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
        $culinary_place = $this->culinaryPlaceModel->get_cp_by_id_api($id)->getRowArray();

        $list_gallery = $this->galleryCulinaryPlaceModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
        
        $culinary_place['gallery'] = $galleries;

        $response = [
            'data' => $culinary_place,
            'status' => 200,
            'message' => [
                "Success display detail information of Culinary Place"
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
        $id = $this->culinaryPlaceModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'contact_person' => $request['contact_person'],
            'capacity' => $request['capacity'],
            'open' => $request['open'],
            'close' => $request['close'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $addCP = $this->culinaryPlaceModel->add_cp_api($requestData);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilityCulinaryPlaceModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->galleryCulinaryPlaceModel->add_gallery_api($id, $gallery);
        $video = $request['video'];
        $addVideo = $this->videoCulinaryPlaceModel->add_video_api($id, array($video));
        $menus = $request['menus'];
        $addMenu = $this->detailMenuModel->add_menu_api($id, $menus);
        if($addCP && $addFacilities && $addGallery && $addVideo && $addMenu) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Culinary Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Culinary Place",
                    "Add Culinary Place: {$addCP}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
                    "Add Video: {$addVideo}",
                    "Add Menu: {$addMenu}",
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
            'address' => $request['address'],
            'contact_person' => $request['contact_person'],
            'capacity' => $request['capacity'],
            'open' => $request['open'],
            'close' => $request['close'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $updateCP = $this->culinaryPlaceModel->update_cp_api($id, $requestData);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilityCulinaryPlaceModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->galleryCulinaryPlaceModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoCulinaryPlaceModel->update_video_api($id, array($video));
        $menus = $request['menus'];
        $updateMenu = $this->detailMenuModel->update_menu_api($id, $menus);
        if($updateCP && $updateFacilities && $updateGallery && $updateVideo && $updateMenu) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Culinary Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Culinary Place",
                    "Update Culinary Place: {$updateCP}",
                    "Update Facilities: {$updateFacilities}",
                    "Update Gallery: {$updateGallery}",
                    "Update Video: {$updateVideo}",
                    "Update Menu: {$updateMenu}",
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
        $deleteCP = $this->culinaryPlaceModel->delete(['id' => $id]);
        if($deleteCP) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Culinary Place"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Culinary Place not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
    
    public function findByRadius()
    {
        $request = $this->request->getPost();
        $contents = $this->culinaryPlaceModel->get_cp_by_radius_api($request)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Rumah Gadang by radius"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->culinaryPlaceModel->list_by_owner($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Culinary Place"
            ]
        ];
        return $this->respond($response);
    }
}
