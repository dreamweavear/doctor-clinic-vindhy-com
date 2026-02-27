<?php

namespace App\Controllers\Receptionist;

use App\Controllers\BaseController;
use App\Models\PatientModel;
use App\Models\VisitModel;
use App\Models\DoctorReceptionistModel;

/**
 * Receptionist Dashboard Controller
 */
class Dashboard extends BaseController
{
    public function index()
    {
        $receptionistId = (int)session()->get('user_id');
        $patientModel = new PatientModel();
        $visitModel = new VisitModel();
        $drModel = new DoctorReceptionistModel();

        $assignedDoctors = $drModel->getDoctorsForReceptionist($receptionistId);
        $doctorIds = array_column($assignedDoctors, 'id');

        // Visits today for assigned doctors
        $todayVisitsCount = 0;
        foreach ($doctorIds as $docId) {
            $todayVisitsCount += $visitModel->countTodayForDoctor($docId);
        }

        return view('receptionist/dashboard', [
            'title' => 'Receptionist Dashboard | Clinic OPD',
            'total_patients' => $patientModel->countForReceptionist($receptionistId),
            'assigned_doctors' => $assignedDoctors,
            'today_visits' => $todayVisitsCount,
            'page' => 'receptionist_dashboard',
        ]);
    }
}
