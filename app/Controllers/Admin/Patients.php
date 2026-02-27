<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatientModel;

/**
 * Admin Patients Controller
 *
 * Read-only view of ALL patients across all doctors.
 */
class Patients extends BaseController
{
    public function index()
    {
        $patientModel = new PatientModel();
        $search = $this->request->getGet('search') ?? '';

        return view('admin/patients/index', [
            'title' => 'All Patients | Admin',
            'patients' => $patientModel->getAll($search),
            'search' => $search,
            'page' => 'admin_patients',
        ]);
    }

    public function view(int $id)
    {
        $patientModel = new PatientModel();
        $patient = $patientModel->getPatientWithOwnership($id, 'admin', 0);

        if (!$patient) {
            return redirect()->to(base_url('admin/patients'))->with('error', 'Patient not found.');
        }

        $visitModel = new \App\Models\VisitModel();
        $visits = $visitModel->getForPatient($id);

        return view('admin/patients/view', [
            'title' => 'Patient Details | Admin',
            'patient' => $patient,
            'visits' => $visits,
            'page' => 'admin_patients',
        ]);
    }
}
