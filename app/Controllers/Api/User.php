<?php

namespace App\Controllers\Api;

use App\Models\AccountModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class User extends ResourceController
{
    
    use ResponseTrait;
    
    protected $accountModel;
    
    public function __construct()
    {
        $this->accountModel = new AccountModel();
    }
    
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $contents = $this->accountModel->get_list_user_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of User"
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
        $contents = $this->accountModel->get_account_by_id_api($id)->getRowArray();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success display detail information of User"
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
        $request = $this->request->getPost();
        $requestData = [
            'id'=> $this->accountModel->get_new_id_api(),
            'username' => $request['username'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'password' => $request['password'],
            'avatar' => $request['avatar'],
            'role_id' => $request['role_id'],
        ];
        $this->accountModel->insert($requestData);
        $response = [
            'status' => 201,
            'message' => [
                "Success create new Users"
            ]
        ];
        return $this->respondCreated($response);
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
        $request = $this->request->getRawInput();
        $requestData = [
            'username' => $request['username'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
            'password' => $request['password'],
            'avatar' => $request['avatar'],
        ];
        $updateAccount = $this->accountModel->update_account_api($id, $requestData);
        if($updateAccount){
            $response = [
                'status' => 200,
                'message' => [
                    "Success update User"
                ]
            ];
            return $this->respond($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update User"
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
        $delete = $this->accountModel->delete_user_api($id);
        if($delete) {
            $response = [
                'status' => 200,
                'message' => [
                    "Success delete User"
                ]
            ];
            return $this->respondDeleted($response);
        } else {
            $response = [
                'status' => 404,
                'message' => [
                    "User not found"
                ]
            ];
            return $this->failNotFound($response);
        }
    }
    
    public function owner()
    {
        $contents = $this->accountModel->get_list_owner_api()->getResult();
        $response = [
            'data' => $contents,
            'status' => 200,
            'message' => [
                "Success get list of Owner"
            ]
        ];
        return $this->respond($response);
    }
}
