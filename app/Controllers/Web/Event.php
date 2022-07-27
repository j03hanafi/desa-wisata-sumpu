<?php

namespace App\Controllers\Web;

use App\Models\CategoryEventModel;
use App\Models\EventModel;
use App\Models\GalleryEventModel;
use App\Models\ReviewModel;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;

class Event extends ResourcePresenter
{
    protected $eventModel;
    protected $galleryEventModel;
    protected $reviewModel;
    protected $categoryEventModel;
    protected $helpers = ['auth', 'url', 'filesystem'];
    
    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->galleryEventModel = new GalleryEventModel();
        $this->reviewModel = new ReviewModel();
        $this->categoryEventModel = new CategoryEventModel();
    }
    
    /**
     * Present a view of resource objects
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
     * Present a view to present a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();
        if (empty($event)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
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
    
        if (url_is('*dashboard*')) {
            return view('dashboard/detail_event', $data);
        }
        return view('web/detail_event', $data);
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $categories = $this->categoryEventModel->get_list_cat_api()->getResultArray();
        $data = [
            'title' => 'New Event',
            'categories' => $categories
        ];
        return view('dashboard/event_form', $data);
    }

    /**
     * Process the creation/insertion of a new resource object.
     * This should be a POST.
     *
     * @return mixed
     */
    public function create()
    {
        $request = $this->request->getPost();
        $id = $this->eventModel->get_new_id_api();
        $requestData = [
            'id' => $id,
            'name' => $request['name'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
            'description' => $request['description'],
            'ticket_price' => $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'category_id' => $request['category'],
            'owner' => $request['owner'],
        ];
        foreach ($requestData as $key => $value) {
            if(empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];
        if (isset($request['video'])){
            $folder = $request['video'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $vidFile = new File($filepath . '/' . $filenames[0]);
            $vidFile->move(FCPATH . 'media/videos');
            delete_files($filepath);
            rmdir($filepath);
            $requestData['video_url'] = $vidFile->getFilename();
        }
        $addEV = $this->eventModel->add_ev_api($requestData, $geojson);
    
        if (isset($request['gallery'])) {
            $folders = $request['gallery'];
            $gallery = array();
            foreach ($folders as $folder) {
                $filepath = WRITEPATH . 'uploads/' . $folder;
                $filenames = get_filenames($filepath);
                $fileImg = new File($filepath . '/' . $filenames[0]);
                $fileImg->move(FCPATH . 'media/photos');
                delete_files($filepath);
                rmdir($filepath);
                $gallery[] = $fileImg->getFilename();
            }
            $this->galleryEventModel->add_gallery_api($id, $gallery);
        }
    
        if ($addEV) {
            return redirect()->to(base_url('dashboard/event') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Present a view to edit the properties of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();
        if (empty($event)) {
            return redirect()->to('dashboard/event');
        }
    
        $list_gallery = $this->galleryEventModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
    
        $categories = $this->categoryEventModel->get_list_cat_api()->getResultArray();
    
        $event['gallery'] = $galleries;
        $data = [
            'title' => 'Edit Event',
            'data' => $event,
            'categories' => $categories
        ];
        return view('dashboard/event_form', $data);
    }

    /**
     * Process the updating, full or partial, of a specific resource object.
     * This should be a POST.
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $request = $this->request->getPost();
        $requestData = [
            'name' => $request['name'],
            'date_start' => $request['date_start'],
            'date_end' => $request['date_end'],
            'description' => $request['description'],
            'ticket_price' => $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'category_id' => $request['category'],
            'owner' => $request['owner'],
        ];
        foreach ($requestData as $key => $value) {
            if(empty($value)) {
                unset($requestData[$key]);
            }
        }
        $geojson = $request['geo-json'];
        if (isset($request['video'])){
            $folder = $request['video'];
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $filenames = get_filenames($filepath);
            $vidFile = new File($filepath . '/' . $filenames[0]);
            $vidFile->move(FCPATH . 'media/videos');
            delete_files($filepath);
            rmdir($filepath);
            $requestData['video_url'] = $vidFile->getFilename();
        } else {
            $requestData['video_url'] = null;
        }
        $updateEV = $this->eventModel->update_ev_api($id, $requestData);
    
        if (isset($request['gallery'])) {
            $folders = $request['gallery'];
            $gallery = array();
            foreach ($folders as $folder) {
                $filepath = WRITEPATH . 'uploads/' . $folder;
                $filenames = get_filenames($filepath);
                $fileImg = new File($filepath . '/' . $filenames[0]);
                $fileImg->move(FCPATH . 'media/photos');
                delete_files($filepath);
                rmdir($filepath);
                $gallery[] = $fileImg->getFilename();
            }
            $this->galleryEventModel->update_gallery_api($id, $gallery);
        } else {
            $this->galleryEventModel->delete_gallery_api($id);
        }
    
        if ($updateEV) {
            return redirect()->to(base_url('dashboard/event') . '/' . $id);
        } else {
            return redirect()->back()->withInput();
        }
    }

    /**
     * Present a view to confirm the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function remove($id = null)
    {
        //
    }

    /**
     * Process the deletion of a specific resource object
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}
