<?php

namespace App\Controllers\Web;

use App\Models\DetailFacilityRumahGadangModel;
use App\Models\GalleryRumahGadangModel;
use App\Models\ReviewModel;
use App\Models\RumahGadangModel;
use CodeIgniter\RESTful\ResourceController;

class RumahGadang extends ResourceController
{
    protected $rumahGadangModel;
    protected $galleryRumahGadangModel;
    protected $detailFacilityRumahGadangModel;
    protected $reviewModel;
    
    protected $helpers = ['auth'];
    
    public function __construct()
    {
        $this->rumahGadangModel = new RumahGadangModel();
        $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
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
        if (empty($rumahGadang)) {
            return redirect()->to(base_url('web/rumahGadang'));
        }
        
        $avg_rating = $this->reviewModel->get_rating('rumah_gadang_id', $id)->getRowArray()['avg_rating'];
    
        $list_facility = $this->detailFacilityRumahGadangModel->get_facility_by_rg_api($id)->getResultArray();
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
    
    
        $rumahGadang['avg_rating'] = $avg_rating;
        $rumahGadang['facilities'] = $facilities;
        $rumahGadang['reviews'] = $list_review;
        $rumahGadang['gallery'] = $galleries;
        
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
    
}
