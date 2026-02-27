<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * RoleFilter
 *
 * Checks the logged-in user's role against the allowed roles for a route.
 * Usage in routes: ['filter' => 'auth:admin'] or ['filter' => 'auth:doctor,receptionist']
 *
 * Note: We pass roles through the route filter argument.
 * E.g. 'auth:admin' allows only admin.
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('role');

        // If arguments contain allowed roles, check against user's role
        if ($arguments !== null && !empty($arguments)) {
            $allowedRoles = is_array($arguments) ? $arguments : explode(',', $arguments[0]);

            if (!in_array($userRole, $allowedRoles, true)) {
                // User doesn't have permission
                return redirect()->to(base_url('dashboard'))
                    ->with('error', 'You do not have permission to access that page.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    // No action needed after
    }
}
