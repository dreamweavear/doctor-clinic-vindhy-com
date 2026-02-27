<?php

namespace App\Controllers;

/**
 * Dashboard Controller
 *
 * Routes authenticated users to their role-specific dashboard.
 */
class Dashboard extends BaseController
{
    public function index()
    {
        $role = session()->get('role');

        return match ($role) {
                'admin' => redirect()->to(base_url('admin/dashboard')),
                'doctor' => redirect()->to(base_url('doctor/dashboard')),
                'receptionist' => redirect()->to(base_url('receptionist/dashboard')),
                default => redirect()->to(base_url('auth/login')),
            };
    }
}
