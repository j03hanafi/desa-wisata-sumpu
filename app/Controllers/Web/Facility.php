<?php

namespace App\Controllers\Web;

use App\Models\FacilityRumahGadangModel;
use CodeIgniter\RESTful\ResourcePresenter;

class Facility extends ResourcePresenter
{
    protected $facilityRumahGadangModel;
    
    protected $helpers = ['auth', 'url', 'filesystem'];
    
    public function __construct()
    {
        $this->facilityRumahGadangModel = new FacilityRumahGadangModel();
    }
    /**
     * Present a view of resource objects
     *
     * @return mixed
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Present a view to present a new single resource object
     *
     * @return mixed
     */
    public function new()
    {
        $id = $this->facilityRumahGadangModel->get_new_id_api();
        $data = [
            'title' => 'New Facility',
            'id' => $id
        ];
        return view('dashboard/facility_form', $data);
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
        $requestData = [
            'id' => $request['id'],
            'facility' => $request['facility'],
        ];
        $addFC = $this->facilityRumahGadangModel->add_fc_api($requestData);
        if ($addFC) {
            return redirect()->to(base_url('dashboard/facility'));
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
        $facility = $this->facilityRumahGadangModel->get_fc_by_id_api($id)->getRowArray();
        $data = [
            'title' => 'Edit Facility',
            'data' => $facility
        ];
        return view('dashboard/facility_form', $data);
        
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
            'facility' => $request['facility'],
        ];
        $updateFC = $this->facilityRumahGadangModel->update_fc_api($id, $requestData);
        if ($updateFC) {
            return redirect()->to(base_url('dashboard/facility'));
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
