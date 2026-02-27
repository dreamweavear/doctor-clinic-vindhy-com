<?php

namespace App\Controllers\Doctor;

use App\Controllers\BaseController;
use App\Models\PrescriptionModel;
use App\Models\PatientModel;
use App\Models\VisitModel;

/**
 * Doctor Prescriptions Controller
 *
 * Create prescription for a visit + print letterpad.
 * Data isolation: only accessible for doctor's own patients.
 */
class Prescriptions extends BaseController
{
    protected PrescriptionModel $prescriptionModel;
    protected PatientModel $patientModel;
    protected VisitModel $visitModel;
    protected int $doctorId;

    public function __construct()
    {
        $this->prescriptionModel = new PrescriptionModel();
        $this->patientModel = new PatientModel();
        $this->visitModel = new VisitModel();
        $this->doctorId = (int)session()->get('user_id');
    }

    public function create(int $visitId)
    {
        $visit = $this->visitModel->getVisitDetails($visitId);

        if (!$visit || (int)$visit['doctor_id'] !== $this->doctorId) {
            return redirect()->to(base_url('doctor/patients'))
                ->with('error', 'Visit not found or access denied.');
        }

        // Check if prescription already exists for this visit
        $existing = $this->prescriptionModel->getForVisit($visitId);
        if ($existing) {
            return redirect()->to(base_url("doctor/prescriptions/view/{$existing['id']}"))
                ->with('info', 'Prescription already exists for this visit.');
        }

        // Previous visit history for this patient
        $previousHistory = $this->prescriptionModel->getPreviousForPatient(
            (int)$visit['patient_id'],
            $visitId,
            3
        );

        return view('doctor/prescriptions/create', [
            'title' => 'Create Prescription | Doctor',
            'visit' => $visit,
            'previous_history' => $previousHistory,
            'page' => 'doctor_patients',
        ]);
    }

    public function store()
    {
        $visitId = (int)$this->request->getPost('visit_id');
        $visit = $this->visitModel->getVisitDetails($visitId);

        if (!$visit || (int)$visit['doctor_id'] !== $this->doctorId) {
            return redirect()->to(base_url('doctor/patients'))
                ->with('error', 'Access denied.');
        }

        $prescriptionData = [
            'visit_id' => $visitId,
            'patient_id' => $visit['patient_id'],
            'doctor_id' => $this->doctorId,
            'notes' => $this->request->getPost('notes'),
            'followup_date' => $this->request->getPost('followup_date') ?: null,
        ];

        $medicines = $this->request->getPost('medicines') ?? [];

        $prescriptionId = $this->prescriptionModel->createWithMedicines($prescriptionData, $medicines);

        if (!$prescriptionId) {
            return redirect()->back()->withInput()
                ->with('error', 'Failed to save prescription. Please try again.');
        }

        return redirect()->to(base_url("doctor/prescriptions/print/{$prescriptionId}"))
            ->with('success', 'Prescription saved successfully.');
    }

    public function view(int $id)
    {
        $prescription = $this->prescriptionModel->getFullPrescription($id);

        if (!$prescription || (int)$prescription['doctor_id'] !== $this->doctorId) {
            return redirect()->to(base_url('doctor/patients'))
                ->with('error', 'Prescription not found or access denied.');
        }

        return view('doctor/prescriptions/view', [
            'title' => 'Prescription Details | Doctor',
            'prescription' => $prescription,
            'page' => 'doctor_patients',
        ]);
    }

    public function printView(int $id)
    {
        $prescription = $this->prescriptionModel->getFullPrescription($id);

        if (!$prescription || (int)$prescription['doctor_id'] !== $this->doctorId) {
            return redirect()->to(base_url('doctor/patients'))
                ->with('error', 'Prescription not found or access denied.');
        }

        return view('doctor/prescriptions/print', [
            'title' => 'Print Prescription',
            'prescription' => $prescription,
        ]);
    }
}
