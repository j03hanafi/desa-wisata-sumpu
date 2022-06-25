<?php

namespace App\Controllers\Api;

use App\Models\DetailFacilityRumahGadangModel;
use App\Models\GalleryRumahGadangModel;
use App\Models\ReviewModel;
use App\Models\RumahGadangModel;
use App\Models\VideoRumahGadangModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class RumahGadang extends ResourceController
{
    use ResponseTrait;

    protected $rumahGadangModel;
    protected $galleryRumahGadangModel;
    protected $videoRumahGadangModel;
    protected $detailFacilityRumahGadangModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->rumahGadangModel = new RumahGadangModel();
        $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
        $this->videoRumahGadangModel = new VideoRumahGadangModel();
        $this->detailFacilityRumahGadangModel = new DetailFacilityRumahGadangModel();
        $this->reviewModel = new ReviewModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->rumahGadangModel->get_list_rg_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Rumah Gadang"
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
        $rumahGadang = $this->rumahGadangModel->get_rg_by_id_api($id)->getRowArray();

        $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $list_video = $this->videoRumahGadangModel->get_video_api($id)->getResultArray();
        $videos = array();
        foreach ($list_video as $video) {
            $videos[] = $video['url'];
        }

        $list_facility = $this->detailFacilityRumahGadangModel->get_facility_by_id_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['facility'];
        }

        $list_review = $this->reviewModel->get_review_object_api('rumah_gadang_id', $id)->getResultArray();

        $rumahGadang['facilities'] = $facilities;
        $rumahGadang['gallery'] = $galleries;
        $rumahGadang['video'] = $videos;
        $rumahGadang['reviews'] = $list_review;

        $response = [
            'data' => $rumahGadang,
            'status' => 200,
            'message' => [
                "Success display detail information of Rumah Gadang"
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
        $id = $this->rumahGadangModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'ticket_price' => $request['ticket_price'],
            'geom' => $request['geom'],
            'contact_person' => $request['contact_person'],
            'recom' => $request['recom'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $addRG = $this->rumahGadangModel->add_rg_api($requestData);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilityRumahGadangModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->galleryRumahGadangModel->add_gallery_api($id, $gallery);
        $video = $request['video'];
        $addVideo = $this->videoRumahGadangModel->add_video_api($id, array($video));
        if($addRG && $addFacilities && $addGallery && $addVideo) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Rumah Gadang"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Rumah Gadang",
                    "Add Rumah Gadang: {$addRG}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
                    "Add Video: {$addVideo}",
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
            'open' => $request['open'],
            'close' => $request['close'],
            'ticket_price' => $request['ticket_price'],
            'geom' => $request['geom'],
            'contact_person' => $request['contact_person'],
            'recom' => $request['recom'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $updateRG = $this->rumahGadangModel->update_rg_api($id, $requestData);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilityRumahGadangModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->galleryRumahGadangModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoRumahGadangModel->update_video_api($id, array($video));
        if($updateRG && $updateFacilities && $updateGallery && $updateVideo) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success update Rumah Gadang"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Rumah Gadang",
                    "Update Rumah Gadang: {$updateRG}",
                    "Update Facilities: {$updateFacilities}",
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
        $deleteRG = $this->rumahGadangModel->delete(['id' => $id]);
        if($deleteRG) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete Rumah Gadang"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "Rumah Gadang not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }

    public function recommendation()
    {

        $contents = $this->rumahGadangModel->get_recommendation_api()->getResultArray();
        for ($index = 0; $index < count($contents); $index++) {
            $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($contents[$index]['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $contents[$index]['gallery'] = $galleries;
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of recommended Rumah Gadang"
            ]
        ];
        return $this->respond($response);
    }

    public function recommendationByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->rumahGadangModel->recommendation_by_owner_api($request['id'])->getResultArray();
        for ($index = 0; $index < count($contents); $index++) {
            $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($contents[$index]['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $contents[$index]['gallery'] = $galleries;
        }

        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of recommended Rumah Gadang"
            ]
        ];
        return $this->respond($response);
    }

    public function updateRecommendation() {
        $request = $this->request->getJSON(true);
        $list_update = $request['update'];
        $updateRecom = $this->rumahGadangModel->update_recom_api($list_update);
        if($updateRecom) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Rumah Gadang Recommendation"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Rumah Gadang Recommendation",
                    "Update Rumah Gadang Recommendation: {$updateRecom}",
                ]
            ];
            return $this->respond($response, 400);
        }
    }

    public function findByName()
    {
        $request = $this->request->getPost();
        $name = $request['name'];
        $contents = $this->rumahGadangModel->get_rg_by_name_api($name)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Rumah Gadang by name"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner() {
        $request = $this->request->getPost();
        $contents = $this->rumahGadangModel->list_by_owner_api($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Rumah Gadang"
            ]
        ];
        return $this->respond($response);
    }
}
