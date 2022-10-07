<?php

namespace App\Controllers\Web;

use App\Models\CategoryEventModel;
use App\Models\EventModel;
use App\Models\GalleryEventModel;
use App\Models\ReviewModel;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourcePresenter;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;

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
        $contents = $this->eventModel->get_list_ev_api()->getResult();
        foreach ($contents as $content) {
            $calendar = $this->getCalendar($content);
            $content->date_next = $calendar[0];
            $content->calendar = $calendar;
        }
    
        usort($contents, function ($a, $b) {
            return $a->date_next <=> $b->date_next;
        });
    
        $now = new DateTimeImmutable('now');
        $events = array();
        foreach ($contents as $content) {
            if ($content->date_next >= $now->format('Y-m-d')) {
                $events[] = (array)$content;
            }
        }
        foreach($contents as $content){
            if ($content->date_next < $now->format('Y-m-d')) {
                $events[] = (array)$content;
            }
        }
        
        $data = [
            'title' => 'Event',
            'data' => $events,
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
        $calendar = $this->getCalendar($event);
    
        $avg_rating = $this->reviewModel->get_rating('event_id', $id)->getRowArray()['avg_rating'];
    
        $list_gallery = $this->galleryEventModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
    
        $list_review = $this->reviewModel->get_review_object_api('event_id', $id)->getResultArray();
    
        $event['date_next'] = $calendar[0];
        $event['calendar'] = $calendar;
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
            'recurs' => $request['repeat'],
            'max_recurs' => $request['occurrence'],
            'description' => $request['description'],
            'ticket_price' => empty($request['ticket_price']) ? "0" : $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'category_id' => $request['category'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
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
            'ticket_price' => empty($request['ticket_price']) ? "0" : $request['ticket_price'],
            'contact_person' => $request['contact_person'],
            'category_id' => $request['category'],
            'owner' => $request['owner'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
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
    
    public function getCalendar($event = null): array
    {
        if (!is_array($event)) {
            $event = (array)$event;
        }
        $start_date = new DateTimeImmutable($event['date_start']);
        if ($event['max_recurs'] == null && $event['date_end'] == null)
        {
            $end_date = $start_date;
        }
        elseif ($event['max_recurs'] == null) {
            $end_date = new DateTimeImmutable($event['date_end']);
        } elseif ($event['date_end'] == null) {
            $end_date = $start_date->modify("+{$event['max_recurs']} {$event['recurs']}");
        } else {
            $dateFromEnd = new DateTimeImmutable($event['date_end']);
            $dateFromRecurs = $start_date->modify("+{$event['max_recurs']} {$event['recurs']}");
            if ($dateFromEnd > $dateFromRecurs) {
                $end_date = $dateFromRecurs;
            } else {
                $end_date = $dateFromEnd;
            }
        }
        
        $calendar = array();
        $now = new DateTimeImmutable('now');
        if ($event['recurs'] == 'none') {
            $calendar[] =$start_date->format('Y-m-d');
        } elseif ($end_date == $start_date) {
            $calendar[] = $event['date_start'];
        }
        else {
            $interval = DateInterval::createFromDateString("1 {$event['recurs']}");
            $dateArrange = new DatePeriod($start_date, $interval ,$end_date);
            foreach($dateArrange as $date){
                if ($date->format('Y-m-d') >= $now->format('Y-m-d')) {
                    $calendar[] = $date->format('Y-m-d');
                }
            }
            foreach($dateArrange as $date){
                if ($date->format('Y-m-d') < $now->format('Y-m-d')) {
                    $calendar[] = $date->format('Y-m-d');
                }
            }
        }
        return $calendar;
    }
    
    public function maps() {
        $contents = $this->eventModel->get_list_ev_api()->getResult();
        foreach ($contents as $content) {
            $calendar = $this->getCalendar($content);
            $content->date_next = $calendar[0];
            $content->calendar = $calendar;
        }
    
        usort($contents, function ($a, $b) {
            return $a->date_next <=> $b->date_next;
        });
    
        $now = new DateTimeImmutable('now');
        $events = array();
        foreach ($contents as $content) {
            if ($content->date_next >= $now->format('Y-m-d')) {
                $events[] = (array)$content;
            }
        }
        foreach($contents as $content){
            if ($content->date_next < $now->format('Y-m-d')) {
                $events[] = (array)$content;
            }
        }
    
        $data = [
            'title' => 'Event',
            'data' => $events,
        ];
        
        return view('maps/event', $data);
    }
    
    public function detail($id = null)
    {
        $event = $this->eventModel->get_ev_by_id_api($id)->getRowArray();
        if (empty($event)) {
            return redirect()->to(substr(current_url(), 0, -strlen($id)));
        }
        $calendar = $this->getCalendar($event);
        
        $avg_rating = $this->reviewModel->get_rating('event_id', $id)->getRowArray()['avg_rating'];
        
        $list_gallery = $this->galleryEventModel->get_gallery_api($id)->getResultArray();
        $galleries = array();
        foreach ($list_gallery as $gallery) {
            $galleries[] = $gallery['url'];
        }
        
        $list_review = $this->reviewModel->get_review_object_api('event_id', $id)->getResultArray();
        
        $event['date_next'] = $calendar[0];
        $event['calendar'] = $calendar;
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
        return view('maps/detail_event', $data);
    }
}
