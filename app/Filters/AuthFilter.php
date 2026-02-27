<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter
 *
 * Checks that the user is logged in via session.
 * If not, redirects to the login page.
 * Also handles the "Remember Me" cookie auto-login.
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Check if user is logged in via session
        if ($session->get('user_id')) {
            return; // Authenticated — continue
        }

        // Try "Remember Me" cookie auto-login
        $response = service('response');
        $cookie = service('request')->getCookie('remember_me');

        if ($cookie) {
            $userModel = new \App\Models\UserModel();
            $user = $userModel->findByRememberToken($cookie);

            if ($user && $user['is_active']) {
                // Restore session
                $session->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'logged_in' => true,
                ]);
                return; // Auto-login successful
            }
        }

        // Not authenticated — redirect to login
        return redirect()->to(base_url('auth/login'))->with('error', 'Please login to continue.');
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    // No action needed after
    }
}
