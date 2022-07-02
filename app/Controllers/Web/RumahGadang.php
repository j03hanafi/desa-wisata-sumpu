<?php

namespace App\Controllers\Web;

use App\Models\DetailFacilityRumahGadangModel;
use App\Models\GalleryRumahGadangModel;
use App\Models\ReviewModel;
use App\Models\RumahGadangModel;
use App\Models\VideoRumahGadangModel;
use CodeIgniter\RESTful\ResourceController;

class RumahGadang extends ResourceController
{
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
        $contents = $this->rumahGadangModel->get_list_rg_api()->getResultArray();
        $data = [
            'title' => 'Rumah Gadang',
            'data' => $contents,
        ];
    
        return view('web/visitor/list_rumah_gadang', $data);
        
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $rumahGadang = $this->rumahGadangModel->get_rg_by_id_api($id)->getRowArray();
        $avg_rating = $this->reviewModel->get_rating('rumah_gadang_id', $id)->getRowArray()['avg_rating'];
    
        $list_facility = $this->detailFacilityRumahGadangModel->get_facility_by_id_api($id)->getResultArray();
        $facilities = array();
        foreach ($list_facility as $facility) {
            $facilities[] = $facility['facility'];
        }
    
        $list_review = $this->reviewModel->get_review_object_api('rumah_gadang_id', $id)->getResultArray();
    
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
    
        $rumahGadang['avg_rating'] = $avg_rating;
        $rumahGadang['facilities'] = $facilities;
        $rumahGadang['reviews'] = $list_review;
        $rumahGadang['gallery'] = $galleries;
        $rumahGadang['video'] = $videos;
        
        $data = [
            'title' => 'Rumah Gadang',
            'data' => $rumahGadang,
        ];
    
        return view('web/visitor/detail_rumah_gadang', $data);
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
    
    public function recommendation() {
        $contents = $this->rumahGadangModel->get_recommendation_api()->getResultArray();
        for ($index = 0; $index < count($contents); $index++) {
            $list_gallery = $this->galleryRumahGadangModel->get_gallery_api($contents[$index]['id'])->getResultArray();
            $galleries = array();
            foreach ($list_gallery as $gallery) {
                $galleries[] = $gallery['url'];
            }
            $contents[$index]['gallery'] = $galleries;
        }
        $data = [
            'title' => 'Home',
            'data' => $contents,
        ];
    
        return view('web/visitor/index', $data);
    }
    
    public function findByName()
    {
        $data = [
            'title' => 'Rumah Gadang',
        ];
        if ($this->request->getMethod() == 'post') {
            $request = $this->request->getPost();
            $name = $request['name'];
            $contents = $this->rumahGadangModel->get_rg_by_name_api($name)->getResultArray();
            $data['data'] = $contents;
            $data['input'] = $name;
        }
        return view('web/visitor/list_rumah_gadang', $data);
    }
    
    public function findByRadius()
    {
        $data = [
            'title' => 'Rumah Gadang',
        ];
        if ($this->request->getMethod() == 'post') {
            $request = $this->request->getPost();
            $contents = $this->rumahGadangModel->get_rg_by_radius_api($request)->getResultArray();
            $data['data'] = $contents;
            $data['radius'] = [$request['lat'], $request['long'], $request['radius']];
        }
    
        return view('web/visitor/list_rumah_gadang', $data);
    }
}
