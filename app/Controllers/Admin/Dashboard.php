<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\PatientModel;
use App\Models\VisitModel;
use App\Models\DoctorReceptionistModel;

/**
 * Admin Dashboard Controller
 */
class Dashboard extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $patientModel = new PatientModel();
        $visitModel = new VisitModel();

        $data = [
            'title' => 'Admin Dashboard | Clinic OPD',
            'total_doctors' => count($userModel->getDoctors()),
            'total_receptionists' => count($userModel->getReceptionists()),
            'total_patients' => $patientModel->countAllResults(),
            'total_visits_today' => $visitModel->where('visit_date', date('Y-m-d'))->countAllResults(),
            'recent_patients' => $patientModel->getAll(''),
            'page' => 'admin_dashboard',
        ];

        // Limit recent patients
        $data['recent_patients'] = array_slice($data['recent_patients'], 0, 5);

        return view('admin/dashboard', $data);
    }
}
