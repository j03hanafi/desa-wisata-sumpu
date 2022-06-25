<?php

namespace App\Controllers\Api;

use App\Models\DetailFacilitySouvenirPlaceModel;
use App\Models\DetailProductModel;
use App\Models\GallerySouvenirPlaceModel;
use App\Models\ReviewModel;
use App\Models\SouvenirPlaceModel;
use App\Models\VideoSouvenirPlaceModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class SouvenirPlace extends ResourceController
{
    use ResponseTrait;

    protected $souvenirPlaceModel;
    protected $gallerySouvenirPlaceModel;
    protected $videoSouvenirPlaceModel;
    protected $detailFacilitySouvenirPlaceModel;
    protected $detailProductModel;
    protected $reviewModel;

    public function __construct()
    {
        $this->souvenirPlaceModel = new SouvenirPlaceModel();
        $this->gallerySouvenirPlaceModel = new GallerySouvenirPlaceModel();
        $this->videoSouvenirPlaceModel = new VideoSouvenirPlaceModel();
        $this->detailFacilitySouvenirPlaceModel = new DetailFacilitySouvenirPlaceModel();
        $this->detailProductModel = new DetailProductModel();
        $this->reviewModel = new ReviewModel();

    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->souvenirPlaceModel->get_list_sp_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Souvenir Place"
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
        $souvenir_place = $this->souvenirPlaceModel->get_sp_by_id_api($id)->getRowArray();

        $list_gallery = $this->gallerySouvenirPlaceModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }

        $list_video = $this->videoSouvenirPlaceModel->get_video_api($id)->getResultArray();
        $videos = array();
        foreach ($list_video as $video) {
            $videos[] = $video['url'];
        }

        $list_facility = $this->detailFacilitySouvenirPlaceModel->get_facility_by_id_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['facility'];
        }

        $list_product = $this->detailProductModel->get_product_by_id_api($id)->getResultArray();

        $list_review = $this->reviewModel->get_review_object_api('souvenir_place_id', $id)->getResultArray();

        $souvenir_place['facilities'] = $facilities;
        $souvenir_place['gallery'] = $galleries;
        $souvenir_place['video'] = $videos;
        $souvenir_place['products'] = $list_product;
        $souvenir_place['reviews'] = $list_review;

        $response = [
            'data' => $souvenir_place,
            'status' => 200,
            'message' => [
                "Success display detail information of Souvenir Place"
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
        $id = $this->souvenirPlaceModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'contact_person' => $request['contact_person'],
            'owner' => $request['owner'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'open' => $request['open'],
            'close' => $request['close'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $addSP = $this->souvenirPlaceModel->add_sp_api($requestData);
        $facilities = $request['facilities'];
        $addFacilities = $this->detailFacilitySouvenirPlaceModel->add_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $addGallery = $this->gallerySouvenirPlaceModel->add_gallery_api($id, $gallery);
        $video = $request['video'];
        $addVideo = $this->videoSouvenirPlaceModel->add_video_api($id, array($video));
        $products = $request['products'];
        $addProduct = $this->detailProductModel->add_product_api($id, $products);
        if($addSP && $addFacilities && $addGallery && $addVideo && $addProduct) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success create new Souvenir Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail create new Souvenir Place",
                    "Add Souvenir Place: {$addSP}",
                    "Add Facilities: {$addFacilities}",
                    "Add Gallery: {$addGallery}",
                    "Add Video: {$addVideo}",
                    "Add Product: {$addProduct}",
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
            'owner' => $request['owner'],
            'employee' => $request['employee'],
            'geom' => $request['geom'],
            'open' => $request['open'],
            'close' => $request['close'],
            'lat' => $request['lat'],
            'long' => $request['long'],
            'description' => $request['description'],
        ];
        $updateSP = $this->souvenirPlaceModel->update_sp_api($id, $requestData);
        $facilities = $request['facilities'];
        $updateFacilities = $this->detailFacilitySouvenirPlaceModel->update_facility_api($id, $facilities);
        $gallery = $request['gallery'];
        $updateGallery = $this->gallerySouvenirPlaceModel->update_gallery_api($id, $gallery);
        $video = $request['video'];
        $updateVideo = $this->videoSouvenirPlaceModel->update_video_api($id, array($video));
        $products = $request['products'];
        $updateProduct = $this->detailProductModel->update_product_api($id, $products);
        if($updateSP && $updateFacilities && $updateGallery && $updateVideo && $updateProduct) {
            $response = [
                'status' => 201,
                'message' => [
                    "Success update Souvenir Place"
                ]
            ];
            return $this->respondCreated($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update Souvenir Place",
                    "Update Souvenir Place: {$updateSP}",
                    "Update Facilities: {$updateFacilities}",
                    "Update Gallery: {$updateGallery}",
                    "Update Video: {$updateVideo}",
                    "Update Product: {$updateProduct}",
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
        $deleteSP = $this->souvenirPlaceModel->delete(['id' => $id]);
        if($deleteSP) {
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

    public function findByName()
    {
        $request = $this->request->getPost();
        $name = $request['name'];
        $contents = $this->souvenirPlaceModel->get_sp_by_name_api($name)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Souvenir Place by name"
            ]
        ];
        return $this->respond($response);
    }

    public function findByProduct()
    {
        $request = $this->request->getPost();
        $product_filter = $request['product'];
        $list_product = $this->detailProductModel->get_product_by_name_api($product_filter)->getResultArray();
        $souvenir_place_id = array();
        foreach ($list_product as $product) {
            $souvenir_place_id[] = $product['souvenir_place_id'];
        }
        $contents =$this->souvenirPlaceModel->get_sp_in_id_api($souvenir_place_id)->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success find Souvenir Place by product"
            ]
        ];
        return $this->respond($response);
    }

    public function listByOwner()
    {
        $request = $this->request->getPost();
        $contents = $this->souvenirPlaceModel->list_by_owner_api($request['id'])->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Souvenir Place"
            ]
        ];
        return $this->respond($response);
    }
}
