<?php

namespace App\Controllers\Api;

use App\Models\AccountModel;
use App\Models\VisitHistoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Files\File;
use CodeIgniter\RESTful\ResourceController;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Password;

class Account extends ResourceController
{
    use ResponseTrait;

    protected $accountModel;
    protected $visitHistoryModel;
    protected $auth;
    /**
     * @var AuthConfig
     */
    protected $config;

    public function __construct()
    {
        $this->accountModel = new AccountModel();
        $this->visitHistoryModel = new VisitHistoryModel();
        $this->config = config('Auth');
        $this->auth = service('authentication');
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
        $users = model(UserModel::class);
    
        // Validate basics first since some password rules rely on these fields
        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
        ];
    
        if (! $this->validate($rules))
        {
            $response = [
                'status' => 400,
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response, 400);
        }
    
        // Validate passwords since they can only be validated properly here
        $rules = [
            'password'     => 'required|strong_password',
            'pass_confirm' => 'required|matches[password]',
        ];
    
        if (! $this->validate($rules))
        {
            $response = [
                'status' => 400,
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response, 400);
        }
    
        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));
    
        // Ensure default group gets assigned if set
        if (! empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }
    
        if (! $users->save($user))
        {
            $response = [
                'status' => 400,
                'message' => $users->errors()
            ];
            return $this->respond($response, 400);
        }
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
        $request = $this->request->getPost();
        $requestData = [
            'username' => $request['username'],
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'phone' => $request['phone'],
        ];
        foreach ($requestData as $key => $value) {
            if(empty($value)) {
                unset($requestData[$key]);
            }
        }
        $img = $this->request->getFile('avatar');
        if ($img == null) {
            $query = $this->accountModel->update_account_users($id, $requestData);
            if ($query) {
                $response = [
                    'status' => 200,
                    'message' => [
                        "Success update account avatar"
                    ]
                ];
                return $this->respond($response);
            }
            $response = [
                'status' => 400,
                'message' => [
                    "Fail update account"
                ]
            ];
            return $this->respond($response, 400);
        } else {
            $validationRule = [
                'avatar' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[avatar]'
                        . '|is_image[avatar]'
                        . '|mime_in[avatar,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ],
            ];
            if (!$this->validate($validationRule)) {
                $response = [
                    'status' => 400,
                    'message' => [
                        "Fail update account"
                    ]
                ];
                return $this->respond($response, 400);
            }
    
            if (!$img->hasMoved()) {
                $filepath = WRITEPATH . 'uploads/' . $img->store();
                $avatar = new File($filepath);
                $avatar->move(FCPATH . 'media/photos');
                $requestData['avatar'] = $avatar->getFilename();
        
                $query = $this->accountModel->update_account_users($id, $requestData);
                if ($query) {
                    $response = [
                        'status' => 200,
                        'message' => [
                            "Success update account w avatar"
                        ]
                    ];
                    return $this->respond($response);
                }
                $response = [
                    'status' => 400,
                    'message' => [
                        "Fail update account"
                    ]
                ];
                return $this->respond($response, 400);
        
            }
        }
        $response = [
            'status' => 400,
            'message' => [
                "Fail update account"
            ]
        ];
        return $this->respond($response, 400);

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
        $rules = [
            'password'     => 'required',
            'pass_confirm' => 'required|matches[password]',
        ];
    
        if (! $this->validate($rules))
        {
            $response = [
                'status' => 400,
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response, 400);
        }
    
        $request = $this->request->getPost();
        $requestData = [
            'password_hash' => Password::hash($request['password']),
            'reset_hash' => null,
            'reset_at' => null,
            'reset_expires' => null,
        ];
        $changePassword = $this->accountModel->change_password_user($request['id'], $requestData);
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
            'user_id' => $request['user_id'],
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

    public function profile() {
        $request = $this->request->getPost();
        $id = $request['id'];
        $owner = $this->accountModel->get_account_by_id_api($id)->getRowArray();
        $response = [
            'data' => $owner,
            'status' => 200,
            'message' => [
                "Success display detail information of User"
            ]
        ];
        return $this->respond($response);
    }

}
