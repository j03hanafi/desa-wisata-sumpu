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
        if ($img != null) {
            $originalName = $img->getName();
            if (!$img->hasMoved() && $originalName != 'default.jpg') {
                $file = $img->getRandomName();
                $createdFolder = mkdir(WRITEPATH . 'uploads/' . $folder);
                if ($createdFolder) {
                    $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                    return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
                }
                $error = "failed create temp folder. Folder: " . $folder . "; Filename:" . $file;
                return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody($error);
            }
            return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($originalName);
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody("file is null, upload failed");
    }
    
    public function remove() {
        $folder = $this->request->getBody();
        if ($folder != 'default.jpg'){
            $filepath = WRITEPATH . 'uploads/' . $folder;
            $deleteFile = delete_files($filepath);
            if (!$deleteFile) {
                return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody("Failed deleting files in directory: ". $filepath);
            }
            $removeDir = rmdir($filepath);
            if (!$removeDir) {
                return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody("Failed deleting directory: ". $filepath);
            }
            return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($filepath);
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
    }
    
    public function photo()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $files = $this->request->getFileMultiple('gallery');
        if ($files != null) {
            foreach ($files as $img) {
                if (!$img->hasMoved()) {
                    $file = $img->getRandomName();
                    $createdFolder = mkdir(WRITEPATH . 'uploads/' . $folder);
                    if ($createdFolder) {
                        $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
                    }
                    $error = "failed create temp folder. Folder: " . $folder . "; Filename:" . $file;
                    return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody($error);
                }
            }
            return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody('');
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody("file is null, upload failed");
    }
    
    public function video()
    {
        $folder = uniqid() . '-' . date('YmdHis');
        $img = $this->request->getFile('video');
        if ($img != null) {
            if (!$img->hasMoved()) {
                $file = $img->getRandomName();
                $createdFolder = mkdir(WRITEPATH . 'uploads/' . $folder);
                if ($createdFolder) {
                    $filepath = WRITEPATH . 'uploads/' . $img->store($folder, $file);
                    return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody($folder);
                }
                $error = "failed create temp folder. Folder: " . $folder . "; Filename:" . $file;
                return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody($error);
            }
            return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(200)->setBody('');
        }
        return $this->response->setHeader('Content-Type', 'text/plain')->setStatusCode(400)->setBody("file is null, upload failed");
    }
}
