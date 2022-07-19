<?php

namespace App\Controllers\Web;

use App\Models\DetailFacilityRumahGadangModel;
use App\Models\FacilityRumahGadangModel;
use App\Models\GalleryRumahGadangModel;
use App\Models\ReviewModel;
use App\Models\RumahGadangModel;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourceController;

class RumahGadang extends ResourceController
{
    protected $rumahGadangModel;
    protected $galleryRumahGadangModel;
    protected $detailFacilityRumahGadangModel;
    protected $reviewModel;
    protected $facilityRumahGadangModel;
    
    protected $helpers = ['auth', 'url'];
    
    public function __construct()
    {
        $this->rumahGadangModel = new RumahGadangModel();
        $this->galleryRumahGadangModel = new GalleryRumahGadangModel();
        $this->detailFacilityRumahGadangModel = new DetailFacilityRumahGadangModel();
        $this->reviewModel = new ReviewModel();
        $this->facilityRumahGadangModel = new FacilityRumahGadangModel();
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
    
        return view('web/list_rumah_gadang', $data);
        
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
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
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
    
        if (url_is('*dashboard*')) {
            return view('dashboard/detail_rumah_gadang', $data);
        }
        return view('web/detail_rumah_gadang', $data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $facilities = $this->facilityRumahGadangModel->get_list_fc_api()->getResultArray();
        $data = [
            'title' => 'Rumah Gadang',
            'facilities' => $facilities,
        ];
        return view('dashboard/new_rumah_gadang', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $request = $this->request->getPost();
        $id = $this->rumahGadangModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'address' => $request['address'],
            'open' => $request['open'],
            'close' => $request['close'],
            'ticket_price' => $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'status' => $request['status'],
            'owner' => $request['owner'],
            'description' => $request['description'],
            'video_url' => '',
        ];
        $geojson = $request['geo-json'];
        $vidFile = $this->request->getFile('video');
        if ($vidFile == null) {
            $requestData['video_url'] = 'none video';
        } else {
            if (!$vidFile->hasMoved()) {
                $filepathVid = WRITEPATH . 'uploads/' . $vidFile->store();
                $fileVid = new File($filepathVid);
                $fileVid->move(FCPATH . 'media/videos');
                $requestData['video_url'] = $fileVid->getFilename();
            } else {
                $requestData['video_url'] = 'Video has moved';
            }
        }
        $addRG = $this->rumahGadangModel->add_rg_api($requestData, $geojson);
        
        $addFacilities = true;
        if (isset($request['facilities'])) {
            $facilities = $request['facilities'];
            $addFacilities = $this->detailFacilityRumahGadangModel->add_facility_api($id, $facilities);
        }
    
        $gallery = array();
        $imgFiles = $this->request->getFileMultiple('gallery');
        if ($imgFiles == null) {
            $gallery[] = 'none files';
        } else {
            foreach ($imgFiles as $img) {
                if (!$img->hasMoved()) {
                    $filepathImg = WRITEPATH . 'uploads/' . $img->store();
                    $fileImg = new File($filepathImg);
                    $fileImg->move(FCPATH . 'media/photos');
                    $gallery[] = $fileImg->getFilename();
                } else {
                    $gallery[] = (!$img->hasMoved()) ?? 'Img has moved';
                }
            }
        }
        $addGallery = $this->galleryRumahGadangModel->add_gallery_api($id, $gallery);
        
        if ($addRG && $addFacilities && $addGallery) {
            return redirect()->to(base_url('dashboard/rumahGadang') . '/' . $id);
        } else {
            return redirect()->back();
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
        
        return view('web/recommendation', $data);
    }
    
}
