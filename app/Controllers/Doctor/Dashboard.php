<?php

namespace App\Controllers\Doctor;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\VisitModel;
use App\Models\FollowupModel;

/**
 * Doctor Dashboard Controller
 */
class Dashboard extends BaseController
{
    public function index()
    {
        $doctorId = session()->get('user_id');
        $patientModel = new PatientModel();
        $visitModel = new VisitModel();
        $followupModel = new FollowupModel();
        $satModel = new \App\Models\SatisfactionModel();

        $satSummary = $satModel->getSummary($doctorId, 30);
        $satTrend = $satModel->getMonthlyTrend($doctorId, 6);

        $data = [
            'title' => 'Doctor Dashboard | Clinic OPD',
            'total_patients' => $patientModel->countForDoctor($doctorId),
            'today_visits' => $visitModel->countTodayForDoctor($doctorId),
            'total_visits' => $visitModel->countForDoctor($doctorId),
            'pending_followups' => $followupModel->countPendingForDoctor($doctorId),
            'today_visit_list' => $visitModel->getTodayForDoctor($doctorId),
            'upcoming_followups' => $followupModel->getUpcomingForDoctor($doctorId, 7),
            'sat_summary' => $satSummary,
            'sat_trend' => $satTrend,
            'page' => 'doctor_dashboard',
        ];

        return view('doctor/dashboard', $data);
    }
}
