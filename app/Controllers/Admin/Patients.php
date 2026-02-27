<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\UserModel;

/**
 * Admin Patients Controller
 *
 * Read-only view of ALL patients across all doctors.
 * Supports doctor-wise + date-range filtering via AJAX.
 */
class Patients extends BaseController
{
    public function index()
    {
        $patientModel = new PatientModel();
        $userModel = new UserModel();
        $search = $this->request->getGet('search') ?? '';

        return view('admin/patients/index', [
            'title' => 'All Patients | Admin',
            'patients' => $patientModel->getAll($search),
            'doctors' => $userModel->getDoctors(),
            'search' => $search,
            'page' => 'admin_patients',
        ]);
    }

    /**
     * AJAX endpoint: GET admin/patients/filter
     * Returns JSON: { patients: [...], count: N }
     */
    public function getFilteredPatients()
    {
        $patientModel = new PatientModel();

        $doctorId = $this->request->getGet('doctor_id') ?? 'all';
        $dateRange = $this->request->getGet('date_range') ?? 'all';
        $fromDate = $this->request->getGet('from_date') ?? '';
        $toDate = $this->request->getGet('to_date') ?? '';
        $search = $this->request->getGet('search') ?? '';

        $patients = $patientModel->getFiltered($doctorId, $dateRange, $fromDate, $toDate, $search);
        $count = count($patients);

        return $this->response
            ->setContentType('application/json')
            ->setJSON([
            'success' => true,
            'count' => $count,
            'patients' => $patients,
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
