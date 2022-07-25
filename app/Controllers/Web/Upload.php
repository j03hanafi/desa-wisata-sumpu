<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class Upload extends ResourceController
{
    protected $helpers = ['filesystem'];
    use ResponseTrait;
    
    public function avatar()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $img = $this->request->getFile('avatar');
        if (!$img->hasMoved()) {
            $file = $img->getRandomName();
            mkdir(WRITEPATH . 'uploads/' . $folder);
            $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
            return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody('');
    }
    
    public function remove() {
        $folder = $this->request->getBody();
        $filepath = WRITEPATH . 'uploads/' . $folder;
        delete_files($filepath);
        rmdir($filepath);
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($filepath);
    }
    
    public function photo()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $files = $this->request->getFileMultiple('gallery');
        foreach ($files as $img) {
            if (!$img->hasMoved()) {
                $file = $img->getRandomName();
                mkdir(WRITEPATH . 'uploads/' . $folder);
                $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
            }
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody('');
    }
    
    public function video()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $img = $this->request->getFile('video');
        if (!$img->hasMoved()) {
            $file = $img->getRandomName();
            mkdir(WRITEPATH . 'uploads/' . $folder);
            $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
            return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody('');
    }
}
