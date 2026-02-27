<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DoctorReceptionistModel;
use App\Models\UserModel;

/**
 * Admin Mapping Controller
 *
 * Manages Doctor-Receptionist assignments.
 */
class Mapping extends BaseController
{
    protected DoctorReceptionistModel $drModel;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->drModel = new DoctorReceptionistModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('admin/mapping/index', [
            'title' => 'Doctor-Receptionist Mapping | Admin',
            'mappings' => $this->drModel->getAllMappings(),
            'doctors' => $this->userModel->getDoctors(),
            'receptionists' => $this->userModel->getReceptionists(),
            'page' => 'admin_mapping',
        ]);
    }

    public function store()
    {
        $doctorId = (int)$this->request->getPost('doctor_id');
        $receptionistId = (int)$this->request->getPost('receptionist_id');

        if (!$doctorId || !$receptionistId) {
            return redirect()->back()->with('error', 'Please select both doctor and receptionist.');
        }

        // Verify roles
        $doctor = $this->userModel->find($doctorId);
        $receptionist = $this->userModel->find($receptionistId);

        if (!$doctor || $doctor['role'] !== 'doctor' || !$receptionist || $receptionist['role'] !== 'receptionist') {
            return redirect()->back()->with('error', 'Invalid selection. Please choose correct roles.');
        }

        $result = $this->drModel->assignReceptionist($doctorId, $receptionistId, session()->get('user_id'));

        if ($result === false) {
            return redirect()->back()->with('warning', 'This mapping already exists.');
        }

        return redirect()->to(base_url('admin/mapping'))->with('success', 'Mapping created successfully.');
    }

    public function delete(int $doctorId, int $receptionistId)
    {
        $this->drModel->removeMapping($doctorId, $receptionistId);
        return redirect()->to(base_url('admin/mapping'))->with('success', 'Mapping removed successfully.');
    }
}
