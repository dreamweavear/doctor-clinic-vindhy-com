<?php

namespace App\Controllers\Doctor;

use App\Controllers\BaseController;
use App\Models\SatisfactionModel;
use App\Models\VisitModel;

/**
 * Doctor Satisfaction Controller
 * Save and report doctor's self-satisfaction ratings per visit.
 */
class Satisfaction extends BaseController
{
    protected SatisfactionModel $satModel;
    protected int $doctorId;

    public function __construct()
    {
        $this->satModel = new SatisfactionModel();
        $this->doctorId = (int)session()->get('user_id');
    }

    /**
     * AJAX/POST: Save satisfaction for a visit.
     */
    public function save()
    {
        $visitId = (int)$this->request->getPost('visit_id');
        $patientId = (int)$this->request->getPost('patient_id');
        $visitDate = $this->request->getPost('visit_date') ?: date('Y-m-d');
        $status = $this->request->getPost('status'); // 'satisfied' or 'dissatisfied'
        $reason = $this->request->getPost('reason') ?: null;

        if (!in_array($status, ['satisfied', 'dissatisfied']) || !$visitId || !$patientId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid data']);
        }

        $ok = $this->satModel->saveSatisfaction(
            $this->doctorId, $visitId, $patientId, $visitDate, $status, $reason
        );

        return $this->response->setJSON([
            'success' => $ok,
            'message' => $ok ? 'Saved!' : 'Error saving.',
        ]);
    }

    /**
     * Satisfaction Report Page.
     */
    public function report()
    {
        $filter = (int)($this->request->getGet('days') ?? 30);
        if (!in_array($filter, [7, 30, 180]))
            $filter = 30;

        $summary = $this->satModel->getSummary($this->doctorId, $filter);
        $trend = $this->satModel->getMonthlyTrend($this->doctorId, 6);
        $milestone = $this->satModel->getMilestoneMessage($this->doctorId);
        $records = $this->satModel->getForDoctor($this->doctorId, 100);

        // All-time stats
        $allTime = $this->satModel->getSummary($this->doctorId, 3650);

        return view('doctor/satisfaction_report', [
            'title' => 'Satisfaction Report | Doctor',
            'page' => 'doctor_satisfaction',
            'summary' => $summary,
            'allTime' => $allTime,
            'trend' => $trend,
            'milestone' => $milestone,
            'records' => $records,
            'filter' => $filter,
        ]);
    }
}
