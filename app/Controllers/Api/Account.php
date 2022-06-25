<?php

namespace App\Controllers\Api;

use App\Models\AccountModel;
use App\Models\VisitHistoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Account extends ResourceController
{
    use ResponseTrait;

    protected $accountModel;
    protected $visitHistoryModel;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->visitHistoryModel = new VisitHistoryModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        //
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
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
     * @throws \ReflectionException
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
                "Success create new account"
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
                    "Success update account"
                ]
            ];
            return $this->respond($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update account"
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
        //
    }

    public function changePassword() {
        $request = $this->request->getPost();
        $requestData = [
            'current_password' => $request['current_password'],
            'new_password' => $request['new_password'],
        ];
        $changePassword = $this->accountModel->change_password_api($request['id'], $requestData);
        if($changePassword){
            $response = [
                'status' => 200,
                'message' => [
                    "Success change password"
                ]
            ];
            return $this->respond($response);
        } else {
            $response = [
                'status' => 400,
                'message' => [
                    "Fail change password"
                ]
            ];
            return $this->fail($response);
        }

    }

    public function visitHistory() {
        $request = $this->request->getPost();
        $list_visit = $this->visitHistoryModel->get_visit_history_by_id_api($request['id'])->getResultArray();
        $list_object = $this->visitHistoryModel->get_visited_object_api($list_visit);
        $response = [
            'data' => $list_object,
            'status' => 200,
            'message' => [
                "Success get list visit history"
            ]
        ];
        return $this->respond($response);
    }

    public function newVisitHistory() {
        $request = $this->request->getPost();
        $requestData = [
            'id' => $this->visitHistoryModel->get_new_id_api(),
            'account_id' => $request['account_id'],
            'object_id' => $request['object_id'],
            'category' => $request['category'],
            'date_visit' => $request['date_visit'],
        ];
        $this->visitHistoryModel->insert($requestData);
        $response = [
            'status' => 201,
            'message' => [
                "Success create new visit history"
            ]
        ];
        return $this->respondCreated($response);
    }


}
