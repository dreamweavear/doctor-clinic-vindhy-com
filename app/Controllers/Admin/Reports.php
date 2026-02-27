<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

/**
 * Admin Reports Controller (stub - expand as needed)
 */
class Reports extends BaseController
{
    public function index()
    {
        return view('admin/reports', [
            'title' => 'Reports | Admin',
            'page' => 'admin_reports',
        ]);
    }
}
