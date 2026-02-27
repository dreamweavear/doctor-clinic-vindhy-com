<?php

namespace App\Controllers\Doctor;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\VisitModel;
use App\Models\PrescriptionModel;

/**
 * Doctor Patients Controller
 *
 * Data isolation: can ONLY see patients where doctor_id = session user_id
 */
class Patients extends BaseController
{
    protected PatientModel $patientModel;
    protected int $doctorId;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
        $this->doctorId = (int)session()->get('user_id');
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $patients = $this->patientModel->getForDoctor($this->doctorId, $search);

        return view('doctor/patients/index', [
            'title' => 'My Patients | Doctor',
            'patients' => $patients,
            'search' => $search,
            'page' => 'doctor_patients',
        ]);
    }

    public function view(int $id)
    {
        // Enforce ownership
        $patient = $this->patientModel->getPatientWithOwnership($id, 'doctor', $this->doctorId);

        if (!$patient) {
            return redirect()->to(base_url('doctor/patients'))
                ->with('error', 'Patient not found or access denied.');
        }

        $visitModel = new VisitModel();
        $prescriptionModel = new PrescriptionModel();
        $visits = $visitModel->getForPatient($id);

        // Attach prescriptions to each visit
        foreach ($visits as &$visit) {
            $visit['prescription'] = $prescriptionModel->getForVisit($visit['id']);
        }

        return view('doctor/patients/view', [
            'title' => "Patient: {$patient['full_name']} | Doctor",
            'patient' => $patient,
            'visits' => $visits,
            'page' => 'doctor_patients',
        ]);
    }
}
