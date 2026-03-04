<?php

namespace App\Controllers;

use App\Controllers\BaseController;

/**
 * Legal Pages Controller — public, no auth required.
 * Serves: Privacy Policy, Terms, Cookie Policy, Disclaimer, Contact
 */
class LegalPages extends BaseController
{
    public function privacyPolicy()
    {
        return view('legal/privacy_policy', [
            'title' => 'गोपनीयता नीति | Privacy Policy — clinic.vindhy.com',
        ]);
    }

    public function termsConditions()
    {
        return view('legal/terms_conditions', [
            'title' => 'सेवा की शर्तें | Terms & Conditions — clinic.vindhy.com',
        ]);
    }

    public function cookiePolicy()
    {
        return view('legal/cookie_policy', [
            'title' => 'कुकी नीति | Cookie Policy — clinic.vindhy.com',
        ]);
    }

    public function disclaimer()
    {
        return view('legal/disclaimer', [
            'title' => 'अस्वीकरण | Disclaimer — clinic.vindhy.com',
        ]);
    }

    public function contact()
    {
        $data = ['title' => 'संपर्क करें | Contact Us — clinic.vindhy.com', 'sent' => false, 'errors' => []];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'name' => 'required|max_length[200]',
                'email' => 'required|valid_email',
                'mobile' => 'permit_empty|max_length[15]',
                'message' => 'required|max_length[2000]',
            ];

            if (!$this->validate($rules)) {
                $data['errors'] = $this->validator->getErrors();
            }
            else {
                // Store inquiry (simple log to writable/logs or email)
                // For now just mark as sent — extend later with email/DB
                $data['sent'] = true;
            }
        }

        return view('legal/contact', $data);
    }
}
