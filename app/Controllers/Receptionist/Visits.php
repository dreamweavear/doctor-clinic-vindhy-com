<?php

namespace App\Controllers\Receptionist;

use App\Controllers\BaseController;
use App\Models\VisitModel;
use App\Models\PatientModel;
use App\Models\DoctorReceptionistModel;

/**
 * Receptionist Visits Controller
 *
 * Create OPD visits for patients of assigned doctors.
 * Print OPD slip after visit creation.
 */
class Visits extends BaseController
{
    protected VisitModel $visitModel;
    protected PatientModel $patientModel;
    protected DoctorReceptionistModel $drModel;
    protected int $receptionistId;

    public function __construct()
    {
        $this->visitModel = new VisitModel();
        $this->patientModel = new PatientModel();
        $this->drModel = new DoctorReceptionistModel();
        $this->receptionistId = (int)session()->get('user_id');
    }

    public function create(int $patientId)
    {
        // Verify patient is in allowed access scope
        $patient = $this->patientModel->getPatientWithOwnership($patientId, 'receptionist', $this->receptionistId);

        if (!$patient) {
            return redirect()->to(base_url('receptionist/patients'))
                ->with('error', 'Patient not found or access denied.');
        }

        return view('receptionist/visits/create', [
            'title' => 'Create Visit | Receptionist',
            'patient' => $patient,
            'page' => 'receptionist_patients',
        ]);
    }

    public function store()
    {
        $patientId = (int)$this->request->getPost('patient_id');

        // Again verify patient access
        $patient = $this->patientModel->getPatientWithOwnership($patientId, 'receptionist', $this->receptionistId);

        if (!$patient) {
            return redirect()->to(base_url('receptionist/patients'))
                ->with('error', 'Access denied.');
        }

        $visitDate = $this->request->getPost('visit_date') ?: date('Y-m-d');
        $doctorId = (int)$patient['doctor_id'];
        $tokenNumber = $this->visitModel->generateToken($doctorId, $visitDate);

        $data = [
            'patient_id' => $patientId,
            'doctor_id' => $doctorId,
            'token_number' => $tokenNumber,
            'visit_date' => $visitDate,
            'chief_complaint' => $this->request->getPost('chief_complaint'),
            'weight' => $this->request->getPost('weight') ?: null,
            'bp' => $this->request->getPost('bp'),
            'temperature' => $this->request->getPost('temperature') ?: null,
            'pulse' => $this->request->getPost('pulse') ?: null,
            'created_by' => $this->receptionistId,
        ];

        $visitId = $this->visitModel->insert($data);

        if (!$visitId) {
            return redirect()->back()->withInput()
                ->with('error', 'Failed to create visit. Please try again.');
        }

        return redirect()->to(base_url("receptionist/visits/slip/{$visitId}"))
            ->with('success', 'Visit created. Token: ' . $tokenNumber);
    }

    public function slip(int $visitId)
    {
        $visit = $this->visitModel->getVisitDetails($visitId);

        if (!$visit) {
            return redirect()->to(base_url('receptionist/patients'))
                ->with('error', 'Visit not found.');
        }

        // Verify the visit's doctor is in receptionist's assigned list
        $assignedDoctorIds = array_map('intval', $this->drModel->getDoctorIdsForReceptionist($this->receptionistId));

        if (!in_array((int)$visit['doctor_id'], $assignedDoctorIds)) {
            return redirect()->to(base_url('receptionist/patients'))
                ->with('error', 'Access denied.');
        }

        return view('receptionist/visits/slip', [
            'title' => 'OPD Slip | Visit #' . $visitId,
            'visit' => $visit,
        ]);
    }
}
