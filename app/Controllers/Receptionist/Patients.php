<?php

namespace App\Controllers\Receptionist;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\DoctorReceptionistModel;

/**
 * Receptionist Patients Controller
 *
 * Data isolation: can ONLY see patients of assigned doctors.
 * Registration form shows ONLY assigned doctors in dropdown.
 */
class Patients extends BaseController
{
    protected PatientModel $patientModel;
    protected DoctorReceptionistModel $drModel;
    protected int $receptionistId;

    public function __construct()
    {
        $this->patientModel = new PatientModel();
        $this->drModel = new DoctorReceptionistModel();
        $this->receptionistId = (int)session()->get('user_id');
    }

    public function index()
    {
        $search = $this->request->getGet('search') ?? '';
        $patients = $this->patientModel->getForReceptionist($this->receptionistId, $search);

        return view('receptionist/patients/index', [
            'title' => 'Patients | Receptionist',
            'patients' => $patients,
            'search' => $search,
            'page' => 'receptionist_patients',
        ]);
    }

    public function create()
    {
        $assignedDoctors = $this->drModel->getDoctorsForReceptionist($this->receptionistId);

        if (empty($assignedDoctors)) {
            return redirect()->to(base_url('receptionist/dashboard'))
                ->with('warning', 'You are not assigned to any doctor. Please contact admin.');
        }

        return view('receptionist/patients/create', [
            'title' => 'Register Patient | Receptionist',
            'assigned_doctors' => $assignedDoctors,
            'page' => 'receptionist_patients',
        ]);
    }

    public function store()
    {
        $doctorId = (int)$this->request->getPost('doctor_id');

        // Verify the doctor is in assigned list (security check)
        $assignedDoctorIds = array_map('intval', $this->drModel->getDoctorIdsForReceptionist($this->receptionistId));
        if (!in_array($doctorId, $assignedDoctorIds)) {
            return redirect()->back()->withInput()
                ->with('error', 'Invalid doctor selection. You can only register patients for your assigned doctors.');
        }

        $rules = [
            'full_name' => 'required|max_length[200]',
            'gender' => 'required|in_list[male,female,other]',
            'mobile' => 'permit_empty|max_length[15]',
            'doctor_id' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $uhid = $this->patientModel->generateUHID();

        $data = [
            'doctor_id' => $doctorId,
            'uhid' => $uhid,
            'full_name' => $this->request->getPost('full_name'),
            'gender' => $this->request->getPost('gender'),
            'dob' => $this->request->getPost('dob') ?: null,
            'age' => $this->request->getPost('age') ?: null,
            'mobile' => $this->request->getPost('mobile'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
            'blood_group' => $this->request->getPost('blood_group'),
            'allergies' => $this->request->getPost('allergies'),
            'registered_by' => $this->receptionistId,
        ];

        $patientId = $this->patientModel->insert($data);

        if (!$patientId) {
            return redirect()->back()->withInput()
                ->with('error', 'Failed to register patient. Please try again.');
        }

        return redirect()->to(base_url("receptionist/visits/create/{$patientId}"))
            ->with('success', "Patient {$data['full_name']} (UHID: {$uhid}) registered successfully. Create a visit for this patient.");
    }

    public function view(int $id)
    {
        // Verify ownership
        $patient = $this->patientModel->getPatientWithOwnership($id, 'receptionist', $this->receptionistId);

        if (!$patient) {
            return redirect()->to(base_url('receptionist/patients'))
                ->with('error', 'Patient not found or access denied.');
        }

        $visitModel = new \App\Models\VisitModel();
        $visits = $visitModel->getForPatient($id);

        return view('receptionist/patients/view', [
            'title' => "Patient: {$patient['full_name']} | Receptionist",
            'patient' => $patient,
            'visits' => $visits,
            'page' => 'receptionist_patients',
        ]);
    }
}
